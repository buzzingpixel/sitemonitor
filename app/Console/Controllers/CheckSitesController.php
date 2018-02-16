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
        $this->emails = (new NotificationEmail)->orderBy('email', 'asc')->get();
    }

    /**
     * Run sites check
     */
    public function runCheck()
    {
        // Get all monitored sites
        $monitoredSites = (new MonitoredSite)->orderBy('name', 'asc')->get();

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
        $statusArray = [
            'up' => true,
            'statusCode' => '',
            'message' => '',
        ];

        // Iterate through URLs
        foreach ($monitoredSite->getUrlsAsArray() as $url) {
            // Check for URL error
            $statusArray = $this->checkUrl($url);

            // If the URL has errors, we can go ahead and break
            if (! $statusArray['up']) {
                $hasErrors = true;
                break;
            }
        }

        // Get the latest site incident
        $latestIncident = (new SiteIncident)->where('monitored_site_id', $monitoredSite->id)
            ->orderBy('created_at', 'desc')
            ->first();

        $monitoredSite->last_checked = new Carbon(null, new \DateTimeZone('UTC'));

        // Check if the site has an error
        if ($hasErrors) {
            // Check if the site needs to go into pending error mode
            if (! $monitoredSite->pending_error) {
                $monitoredSite->pending_error = true;
                $monitoredSite->save();
                $this->consoleOutput->writeln(
                    "<comment>{$monitoredSite->name} has a pending error...</comment>"
                );
                return;
            }

            // We know now the site is down

            if (! $latestIncident || $latestIncident->event_type !== 'down') {
                $latestIncident = new SiteIncident();
                $latestIncident->monitored_site_id = $monitoredSite->id;
                $latestIncident->event_type = 'down';
                $latestIncident->status_code = $statusArray['statusCode'];
                $latestIncident->message = $statusArray['message'];
                $latestIncident->save();
                $monitoredSite->has_error = true;

                $this->sendNotification($monitoredSite);
            }

            $monitoredSite->save();
            $this->consoleOutput->writeln(
                "<error>{$monitoredSite->name} is down!</error>"
            );

            return;
        }

        $this->consoleOutput->writeln(
            "<info>{$monitoredSite->name} is up</info>"
        );

        if ($latestIncident && $latestIncident->event_type === 'down') {
            $latestIncident = new SiteIncident();
            $latestIncident->monitored_site_id = $monitoredSite->id;
            $latestIncident->event_type = 'up';
            $latestIncident->status_code = $statusArray['statusCode'];
            $latestIncident->message = $statusArray['message'];
            $latestIncident->save();

            $monitoredSite->pending_error = false;
            $monitoredSite->has_error = false;
            $monitoredSite->save();

            $this->sendNotification($monitoredSite);

            return;
        }

        if ($monitoredSite->pending_error) {
            $monitoredSite->pending_error = false;
            $monitoredSite->save();
        }

        $monitoredSite->save();
    }

    /**
     * Check a URL
     * @param string $url
     * @return array Returns array of status
     */
    private function checkUrl($url)
    {
        $return = [
            'up' => true,
            'statusCode' => '',
            'message' => '',
        ];

        try {
            $client = new Client([
                'http_errors' => false
            ]);

            $response = $client->get($url);

            $statusCode = $response->getStatusCode();
            $hasErrors = $response->getStatusCode() !== 200;

            $return['statusCode'] = $statusCode;
            $return['message'] = "The URL \"{$url}\" returned a status of {$statusCode}";

            if ($hasErrors) {
                $return['up'] = false;
            }

            return $return;
        } catch (\Exception $e) {
            $return['up'] = false;
            $return['message'] = "A Guzzle Exception Occurred: {$e->getMessage()}";
            return $return;
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
