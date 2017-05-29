<?php

namespace App\Console\Controllers;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\Eloquent\Collection;
use App\NotificationEmail;
use App\Ping;
use Illuminate\Mail\Message;

/**
 * Class CheckPingsController
 */
class CheckPingsController
{
    /** @var ConsoleOutput $consoleOutput */
    private $consoleOutput;

    /** @var Collection */
    private $emails;

    /** @var int $startTime */
    private $startTime;

    /**
     * CheckSitesController constructor.
     */
    public function __construct()
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->emails = NotificationEmail::orderBy('email', 'asc')->get();
        $this->startTime = time();
    }

    /**
     * Run pings check
     */
    public function runCheck()
    {
        // Get all monitored sites
        $ping = Ping::orderBy('name', 'asc')->get();

        // Send each site record to the checkSite method
        $ping->each([
            $this,
            'checkPing'
        ]);
    }

    /**
     * Check a ping
     * @param Ping $ping
     */
    public function checkPing(Ping $ping)
    {
        // Check if site is missing
        if ($ping->getHealthStatus() === 'pastWarning') {
            // Notify on console that ping is missing
            $this->consoleOutput->writeln("<error>{$ping->name} is missing</error>");

            // If there is no error set, send notification and set error
            if (! $ping->has_error) {
                $ping->has_error = true;
                $ping->save();
                $this->consoleOutput->writeln("<error>Sending notification email(s) about {$ping->name}</error>");
                $this->sendNotification($ping);
            }

            return;
        }

        // Check if overdue
        if ($ping->getHealthStatus() === 'pastExpect') {
            $this->consoleOutput->writeln("<comment>{$ping->name} is overdue</comment>");
            return;
        }

        // Notify on console that ping is healthy
        $this->consoleOutput->writeln("<info>{$ping->name} is healthy</info>");

        // If error is set, send notification and clear error
        if ($ping->has_error) {
            $ping->has_error = false;
            $ping->save();
            $this->consoleOutput->writeln("<info>Sending notification email(s) about {$ping->name}</info>");
            $this->sendNotification($ping);
        }
    }

    /**
     * Send notification
     * @param Ping $ping
     */
    private function sendNotification(Ping $ping)
    {
        $status = $ping->has_error ? 'is missing' : 'is now healthy';

        // Send an email for each address
        foreach ($this->emails as $email) {
            \Mail::raw(
                "{$ping->name} {$status}",
                function (Message $message) use ($ping, $status, $email) {
                    $message->to($email->email);
                    $message->subject("Ping: {$ping->name} {$status}");
                    $message->setBody("Ping: {$ping->name} {$status}");
                }
            );
        }
    }
}
