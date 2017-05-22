<?php

namespace App\Http\Controllers;

use App\MonitoredSite;
use App\NotificationEmail;
use App\User;
use Illuminate\Contracts\Auth\Guard;

/**
 * Class Dashboard
 */
class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     * @param Guard $auth
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function index(Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        if (! $currentUser->is_admin) {
            throw new \Exception('User privileges do not allow access');
        }

        return view('dashboard', [
            'monitoredSites' => MonitoredSite::all(),
            'notificationEmails' => NotificationEmail::all(),
            'users' => User::where('id', '!=', $currentUser->id)->get()
        ]);
    }

    /**
     * Create site
     * @param Guard $auth
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function createSite(Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        if (! $currentUser->is_admin) {
            throw new \Exception('User priveleges do not allow access');
        }

        // Make sure we have name and urls
        if (! request('name') || ! request('urls')) {
            throw new \Exception('"name" and "urls" field required');
        }

        // Create a monitored site model
        $monitoredSite = new MonitoredSite();

        // Add name
        $monitoredSite->name = request('name');

        // Add urls
        $monitoredSite->urls = request('urls');

        // Save the monitored site
        $monitoredSite->save();

        // Redirect to the dashboard
        return redirect('/dashboard');
    }

    /**
     * Edit site
     * @param MonitoredSite $monitoredSite
     * @param Guard $auth
     * @return array
     * @throws \Exception
     */
    public function editSite(MonitoredSite $monitoredSite, Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        if (! $currentUser->is_admin) {
            throw new \Exception('User priveleges do not allow access');
        }

        return view('editSite', [
            'monitoredSite' => $monitoredSite
        ]);
    }

    /**
     * Update site
     * @param MonitoredSite $monitoredSite
     * @param Guard $auth
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function updateSite(MonitoredSite $monitoredSite, Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        if (! $currentUser->is_admin) {
            throw new \Exception('User priveleges do not allow access');
        }

        // Make sure we have name and urls
        if (! request('name') || ! request('urls')) {
            throw new \Exception('"name" and "urls" field required');
        }

        // Update name
        $monitoredSite->name = request('name');

        // Update URLs
        $monitoredSite->urls = request('urls');

        // Save the monitored site
        $monitoredSite->save();

        // Redirect to the dashboard
        return redirect('/dashboard');
    }

    /**
     * Delete site
     * @param MonitoredSite $monitoredSite
     * @param Guard $auth
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteSite(MonitoredSite $monitoredSite, Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        if (! $currentUser->is_admin) {
            throw new \Exception('User priveleges do not allow access');
        }

        // Delete the site
        $monitoredSite->delete();

        // Redirect to the dashboard
        return redirect('/dashboard');
    }

    /**
     * Add email
     * @param Guard $auth
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function addEmail(Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        if (! $currentUser->is_admin) {
            throw new \Exception('User priveleges do not allow access');
        }

        // Make sure we have name and urls
        if (! request('email')) {
            throw new \Exception('"email" field required');
        }

        // Create a monitored site model
        $notificationEmail = new NotificationEmail();

        // Add email
        $notificationEmail->email = request('email');

        // Save the Email
        $notificationEmail->save();

        // Redirect to the dashboard
        return redirect('/dashboard');
    }

    /**
     * Delete email
     * @param NotificationEmail $notificationEmail
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteEmail(NotificationEmail $notificationEmail, Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        if (! $currentUser->is_admin) {
            throw new \Exception('User priveleges do not allow access');
        }

        // Delete the site
        $notificationEmail->delete();

        // Redirect to the dashboard
        return redirect('/dashboard');
    }

    /**
     * Update users
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function updateUsers(Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        if (! $currentUser->is_admin) {
            throw new \Exception('User priveleges do not allow access');
        }

        // Get users from post
        $users = request('users');

        // Make sure it's an array
        if (! is_array($users)) {
            $users = array();
        }

        foreach ($users as $userId => $userInput) {
            /** @var User $user */
            $user = User::where('id', $userId)->first();
            $user->is_admin = $userInput['is_admin'];
            $user->save();
        }

        // Redirect to the dashboard
        return redirect('/dashboard');
    }
}
