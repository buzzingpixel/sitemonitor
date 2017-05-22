<?php

namespace App\Console\Controllers;

use App\MonitoredSite;
use App\NotificationEmail;
use App\SiteIncident;
use Carbon\Carbon;
use Symfony\Component\Console\Output\ConsoleOutput;
use GuzzleHttp\Client;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Mail\Message;

/**
 * Class CheckSitesController
 */
class CheckSitesController
{
    /** @var ConsoleOutput $consoleOutput */
    private $consoleOutput;

    /** @var Collection */
    private $emails;

    /**
     * CheckSitesController constructor.
     */
    public function __construct()
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->emails = NotificationEmail::all();
    }

    /**
     * Run sites check
     */
    public function runCheck()
    {
        // Get all monitored sites
        $monitoredSites = MonitoredSite::all();

        // Send each site record to the checkSite method
        $monitoredSites->each([
            $this,
            'checkSite'
        ]);
    }

    /**
     * Check a site
     * @param MonitoredSite $monitoredSite
     */
    public function checkSite(MonitoredSite $monitoredSite)
    {
        $hasErrors = false;

        // Get the URLs
        $urls = array_map(function ($i) {
            return trim($i);
        }, explode(',', $monitoredSite->urls));

        // Iterate through URLs
        foreach ($urls as $url) {
            // Check for URL error
            $hasErrors = $this->checkUrl($url);

            // If the URL has errors, we can go ahead and break
            if ($hasErrors) {
                break;
            }
        }

        // Get the latest site incident
        $latestIncident = SiteIncident::where('monitored_site_id', $monitoredSite->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $monitoredSite->last_checked = new Carbon();

        // If the site has an error, we need to add a down event if it does not already exist
        if ($hasErrors) {
            if (! $latestIncident || $latestIncident->event_type !== 'down') {
                $latestIncident = new SiteIncident();
                $latestIncident->monitored_site_id = $monitoredSite->id;
                $latestIncident->event_type = 'down';
                $latestIncident->save();
                $monitoredSite->has_error = true;

                $this->sendNotification($monitoredSite);
            }

            $monitoredSite->save();
            $this->consoleOutput->writeln("<error>{$monitoredSite->name} is down!</error>");

            return;
        }

        $this->consoleOutput->writeln("<info>{$monitoredSite->name} is up</info>");

        if ($latestIncident && $latestIncident->event_type === 'down') {
            $latestIncident = new SiteIncident();
            $latestIncident->monitored_site_id = $monitoredSite->id;
            $latestIncident->event_type = 'up';
            $latestIncident->save();

            $monitoredSite->has_error = false;
            $monitoredSite->save();

            $this->sendNotification($monitoredSite);

            return;
        }

        $monitoredSite->save();
    }

    /**
     * Check a URL
     * @param string $url
     * @return bool Returns true if site does not have 200 status
     */
    public function checkUrl($url)
    {
        try {
            // Get a new Guzzle client
            $client = new Client([
                'http_errors' => false
            ]);

            // Get the URL
            $response = $client->get($url);

            // Return true if errors, false if no errors
            return $response->getStatusCode() !== 200;
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * Send notification
     * @param MonitoredSite $monitoredSite
     */
    private function sendNotification(MonitoredSite $monitoredSite)
    {
        $status = $monitoredSite->has_error ? 'down' : 'up';

        // Send an email for each address
        foreach ($this->emails as $email) {
            \Mail::raw(
                "{$monitoredSite->name} is {$status}",
                function (Message $message) use ($monitoredSite, $status, $email) {
                    $message->to($email->email);
                    $message->subject("{$monitoredSite->name} is {$status}");
                    $message->setBody("{$monitoredSite->name} is {$status}");
                }
            );
        }
    }
}
