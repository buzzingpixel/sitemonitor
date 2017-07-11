<?php

namespace App\Http\Controllers;

use App\Service\Messages;
use Illuminate\Contracts\Auth\Guard;
use App\Reminder;
use App\User;
use Carbon\Carbon;

/**
 * Class RemindersController
 */
class RemindersController extends Controller
{
    /** @var array $postErrors */
    private $postErrors = array();

    /** @var array $postValues */
    private $postValues = array();

    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:reminders');
    }

    /**
     * Index
     */
    public function index()
    {
        return view('reminders.index', [
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues,
        ]);
    }

    /**
     * Create reminder
     * @param Guard $auth
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \InvalidArgumentException
     */
    public function create(Guard $auth)
    {
        // Set post values
        $name = $this->postValues['name'] = request('name');
        $body = $this->postValues['body'] = request('body');
        $startRemindingOn = $this->postValues['start_reminding_on'] =
            request('start_reminding_on');

        // Set name error if applicable
        if (! $name) {
            $this->postErrors['name'] = 'The "Reminder Name" field is required';
        }

        // Set name error if applicable
        if (! $startRemindingOn) {
            $this->postErrors['start_reminding_on'] =
                'The "Start Reminding On" field is required';
        }

        // Check reminders field format
        if (! isset($this->postErrors['start_reminding_on'])) {
            // Turn the date into an array
            $dateCheck = explode('-', $startRemindingOn);

            if (count($dateCheck) !== 3 ||
                ! is_numeric($dateCheck[0]) ||
                ! is_numeric($dateCheck[1]) ||
                ! is_numeric($dateCheck[2]) ||
                strlen($dateCheck[0]) !== 4 ||
                strlen($dateCheck[1]) !== 2 ||
                strlen($dateCheck[2]) !== 2
            ) {
                $this->postErrors['start_reminding_on'] =
                    'The "Start Reminding On" field must be formatted as "2016-01-01"';
            }
        }

        // Check for errors
        if (count($this->postErrors) > 0) {
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                $this->postErrors,
                'danger'
            );

            // Return the view
            return $this->index();
        }

        // Create new reminder model
        $reminder = new Reminder();

        // Set the name
        $reminder->name = $name;

        // Set the body
        $reminder->body = $body;

        // Set is_complete
        $reminder->is_complete = false;

        // Get the current user
        /** @var User $currentUser */
        $currentUser = $auth->user();

        // Create a new DateTimeZone class
        $timeZone = new \DateTimeZone($currentUser->timezone);

        // Create a Carbon class for start reminding on
        $startRemindingOn = Carbon::createFromFormat(
            'Y-m-d H:i:s',
            "{$startRemindingOn} 0:00:00",
            $timeZone
        );

        // Set start_reminding_on
        $reminder->start_reminding_on = $startRemindingOn;

        // Save the reminder
        $reminder->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$name} was added successfully.",
            'success',
            true
        );

        // Redirect to the reminders page
        return redirect('/reminders');
    }
}
