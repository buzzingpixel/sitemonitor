<?php

namespace App\Http\Controllers;

use App\Service\Messages;
use Illuminate\Contracts\Auth\Guard;
use App\Reminder;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\View\View;
use \Illuminate\Http\RedirectResponse;

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
     * @return View
     */
    public function index() : View
    {
        return view('reminders.index', [
            'reminders' => Reminder::orderBy('start_reminding_on')
                ->where('is_complete', '!=', '1')
                ->get(),
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues,
        ]);
    }

    /**
     * Create reminder
     * @param Guard $auth
     * @return View|RedirectResponse
     * @throws \InvalidArgumentException
     */
    public function create(Guard $auth)
    {
        // Create new reminder model
        $reminder = new Reminder();

        // Send to the edit method for creation
        return $this->edit($reminder, $auth);
    }

    /**
     * View reminder
     * @param Reminder $reminder
     * @return View
     */
    public function view(Reminder $reminder) : View
    {
        // Set values
        $this->postValues['name'] = $this->postValues['name'] ?? $reminder->name;
        $this->postValues['body'] = $this->postValues['body'] ?? $reminder->body;
        $this->postValues['start_reminding_on'] =
            $this->postValues['start_reminding_on'] ??
            $reminder->start_reminding_on->format('Y-m-d');

        // Return the view
        return view('reminders.index', [
            'reminders' => new Collection(),
            'editReminder' => $reminder,
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues,
        ]);
    }

    /**
     * Edit a reminder
     * @param Reminder $reminder
     * @param Guard $auth
     * @return View|RedirectResponse
     * @throws \InvalidArgumentException
     */
    public function edit(Reminder $reminder, Guard $auth)
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
            if (\Request::segment(3)) {
                return $this->view($reminder);
            }
            return $this->index();
        }

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

        // Set the message
        $message = "{$name} was added successfully.";
        if (\Request::segment(3)) {
            $message = "{$name} was edited successfully.";
        }

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            $message,
            'success',
            true
        );

        // Redirect to the reminders page
        return redirect('/reminders');
    }
}
