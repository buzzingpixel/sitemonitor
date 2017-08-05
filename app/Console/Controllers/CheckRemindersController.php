<?php

namespace App\Console\Controllers;

use Symfony\Component\Console\Output\ConsoleOutput;
use Illuminate\Database\Eloquent\Collection;
use App\NotificationEmail;
use App\Reminder;
use Carbon\Carbon;
use Illuminate\Mail\Message;

/**
 * Class CheckRemindersController
 */
class CheckRemindersController
{
    /** @var ConsoleOutput $consoleOutput */
    private $consoleOutput;

    /** @var Collection */
    private $emails;

    /**
     * CheckRemindersController constructor
     */
    public function __construct()
    {
        $this->consoleOutput = new ConsoleOutput();
        $this->emails = NotificationEmail::orderBy('email', 'asc')->get();
    }

    /**
     * Run reminders check
     */
    public function runCheck()
    {
        // Get applicable notifications
        $reminders = Reminder::where('is_complete', '!=', 1)
            ->whereDate(
                'start_reminding_on',
                '<',
                Carbon::today()->toDateString()
            )
            ->get();

        // Send each record to the check reminder method
        $reminders->each([
            $this,
            'checkReminder'
        ]);
    }

    /**
     * Check a reminder
     * @param Reminder $reminder
     */
    public function checkReminder(Reminder $reminder)
    {
        // If no reminder has been sent, go ahead and send it
        if (! $reminder->last_reminder_sent) {
            $this->sendReminder($reminder);
            return;
        }

        // Get hours since last sent
        $hours = $reminder->last_reminder_sent->diffInHours(Carbon::now());

        // If it has been 20 or more hours, send
        if ($hours >= 20) {
            $this->sendReminder($reminder);
            return;
        }

        // Output info on the console
        $this->consoleOutput->writeln(
            "<info>The reminder \"{$reminder->name}\" is due. An email is not due to be send for this reminder.</info>"
        );
    }

    /**
     * Send reminder
     * @param Reminder $reminder
     */
    public function sendReminder(Reminder $reminder)
    {
        // Set subject
        $subject = "The reminder \"{$reminder->name}\" is due";

        // Set body
        $url = \URL::to('/reminders');
        $body = "{$subject}.\n\n{$url}";

        // Output info on the console
        $this->consoleOutput->writeln("<info>{$subject}. Sending email...</info>");

        // Send an email for each address
        $this->emails->each(
            function (NotificationEmail $email) use ($subject, $body) {
                \Mail::raw(
                    $subject,
                    function (Message $message) use ($email, $subject, $body) {
                        $message->to($email->email);
                        $message->subject($subject);
                        $message->setBody($body);
                    }
                );
            }
        );

        // Update the reminder last sent parameter
        $reminder->last_reminder_sent = new Carbon();
        $reminder->save();
    }
}
