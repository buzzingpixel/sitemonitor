<?php

namespace App\Http\Controllers;

use App\MonitoredSite;
use App\Service\Messages;

/**
 * Class SitesController
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

            // Add an error message
            if (count($this->postErrors) > 0) {
                Messages::addMessage(
                    'postErrors',
                    'There were errors with your submission',
                    $this->postErrors,
                    'danger'
                );
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

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$monitoredSite->name} was added successfully",
            'success',
            true
        );

        // Redirect to the sites page
        return redirect('/sites');
    }

    /**
     * Show site incidents
     * @param MonitoredSite $monitoredSite
     * @return \Illuminate\Http\Response
     */
    public function showIncidents(MonitoredSite $monitoredSite)
    {
        return view('siteIncidents', [
            'monitoredSite' => $monitoredSite
        ]);
    }

    /**
     * View site for editing
     * @param MonitoredSite $monitoredSite
     * @return \Illuminate\Http\Response
     */
    public function view(MonitoredSite $monitoredSite)
    {
        return view('editSite', [
            'monitoredSite' => $monitoredSite,
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }

    /**
     * Perform site edit
     * @param MonitoredSite $monitoredSite
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function edit(MonitoredSite $monitoredSite)
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

            // Add an error message
            if (count($this->postErrors) > 0) {
                Messages::addMessage(
                    'postErrors',
                    'There were errors with your submission',
                    $this->postErrors,
                    'danger'
                );
            }

            // Return the view
            return $this->view($monitoredSite);
        }

        // Update name
        $monitoredSite->name = request('name');

        // Update URLs
        $monitoredSite->urls = request('urls');

        // Save the monitored site
        $monitoredSite->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$monitoredSite->name} was updated successfully",
            'success',
            true
        );

        // Redirect to the sites page
        return redirect('/sites');
    }

    /**
     * Delete site
     * @param MonitoredSite $monitoredSite
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function delete(MonitoredSite $monitoredSite)
    {
        // Delete the site
        $monitoredSite->delete();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$monitoredSite->name} was deleted successfully",
            'success',
            true
        );

        // Redirect to the sites page
        return redirect('/sites');
    }
}
