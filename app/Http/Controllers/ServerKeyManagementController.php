<?php

namespace App\Http\Controllers;

use App\Server;
use App\Service\Ssh;

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

    /**
     * View server for editing
     * @param Server $server
     * @param Ssh $ssh
     * @return \Illuminate\Http\Response
     */
    public function listServerKeys(Server $server, Ssh $ssh)
    {
        return view('servers.listServerKeys', [
            'server' => $server,
            'keys' => $ssh->getAuthorizedKeys($server),
        ]);
    }
}
