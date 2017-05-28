<?php

namespace App\Http\Controllers;

use App\MonitoredSite;

/**
 * Class Dashboard
 */
class SitesController extends Controller
{
    /**
     * Create a new controller instance.
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
            'monitoredSites' => MonitoredSite::orderBy('name', 'asc')->get()
        ]);
    }
}
