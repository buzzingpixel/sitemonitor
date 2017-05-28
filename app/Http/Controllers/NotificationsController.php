<?php

namespace App\Http\Controllers;

use App\NotificationEmail;
use App\Service\Messages;

/**
 * Class NotificationsController
 */
class NotificationsController extends Controller
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
        $this->middleware('auth');
        $this->middleware('CheckPrivileges');
    }

    /**
     * Show the monitored sites
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('notifications', [
            'notificationEmails' => NotificationEmail::orderBy('email', 'asc')->get(),
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }

    /**
     * Create a new site to monitor
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Set post values
        $this->postValues['email'] = request('email');

        // Make sure we have an email
        if (! request('email')) {
            // Set email error
            $this->postErrors['email'] = 'The "Email" field is required';

            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                $this->postErrors,
                'danger'
            );

            // Return the view
            return $this->index();
        }

        // Create a NotificationEmail model
        $notificationEmail = new NotificationEmail();

        // Add email
        $notificationEmail->email = request('email');

        // Save the Email
        $notificationEmail->save();

        // Save the email
        $notificationEmail->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$notificationEmail->email} was added successfully",
            'success',
            true
        );

        // Redirect to the sites page
        return redirect('/notifications');
    }
    /**
     * Delete email
     * @param NotificationEmail $notificationEmail
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(NotificationEmail $notificationEmail)
    {
        // Delete the site
        $notificationEmail->delete();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$notificationEmail->email} was deleted successfully",
            'success',
            true
        );

        // Redirect to the dashboard
        return redirect('/notifications');
    }
}
