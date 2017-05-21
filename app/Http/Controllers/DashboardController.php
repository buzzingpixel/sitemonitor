<?php

namespace App\Http\Controllers;

use App\MonitoredSite;
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
            'monitoredSites' => MonitoredSite::all()
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
     * Edit site
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
}
