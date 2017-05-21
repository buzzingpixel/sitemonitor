<?php

namespace App\Http\Controllers;

use App\MonitoredSite;
use App\NotificationEmail;
use Illuminate\Http\Request;

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
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('dashboard', [
            'monitoredSites' => MonitoredSite::all(),
            'notificationEmails' => NotificationEmail::all()
        ]);
    }

    /**
     * Create site
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function createSite()
    {
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
     * @return array
     */
    public function editSite(MonitoredSite $monitoredSite)
    {
        return view('editSite', [
            'monitoredSite' => $monitoredSite
        ]);
    }

    /**
     * Update site
     * @param MonitoredSite $monitoredSite
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function updateSite(MonitoredSite $monitoredSite)
    {
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
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteSite(MonitoredSite $monitoredSite)
    {
        // Delete the site
        $monitoredSite->delete();

        // Redirect to the dashboard
        return redirect('/dashboard');
    }

    /**
     * Add email
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function addEmail()
    {
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
    public function deleteEmail(NotificationEmail $notificationEmail)
    {
        // Delete the site
        $notificationEmail->delete();

        // Redirect to the dashboard
        return redirect('/dashboard');
    }
}
