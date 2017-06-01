<?php

namespace App\Http\Controllers;

use App\Server;

/**
 * Class ServerKeyManagementController
 */
class ServerKeyManagementController extends Controller
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:servers');
    }

    /**
     * Show users and admin status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('servers.serverKeyManagement', [
            'servers' => Server::orderBy('name', 'asc')->get(),
        ]);
    }
}
