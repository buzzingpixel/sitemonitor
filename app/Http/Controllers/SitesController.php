<?php

namespace App\Http\Controllers;

use App\MonitoredSite;

/**
 * Class Dashboard
 */
class SitesController extends Controller
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
     * @throws \Exception
     */
    public function index()
    {
        return view('sites', [
            'monitoredSites' => MonitoredSite::orderBy('name', 'asc')->get(),
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }

    /**
     * Create a new site to monitor
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function create()
    {
        // Set post values
        $this->postValues['name'] = request('name');
        $this->postValues['urls'] = request('urls');

        // Make sure we have name and urls
        if (! request('name') || ! request('urls')) {
            // Set name error
            if (! request('name')) {
                $this->postErrors['name'] = 'The "Site Name" field is required';
            }

            // Set urls error
            if (! request('urls')) {
                $this->postErrors['urls'] = 'The "Site URLs to check" field is required';
            }

            // Return the view
            return $this->index();
        }

        // Create a monitored site model
        $monitoredSite = new MonitoredSite();

        // Add name
        $monitoredSite->name = request('name');

        // Add urls
        $monitoredSite->urls = request('urls');

        // Save the monitored site
        $monitoredSite->save();

        // Redirect to the sites page
        return redirect('/sites');
    }
}
