<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Server;
use App\Service\Ssh;
use App\Service\Messages;

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
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:servers');
    }

    /**
     * Show users and admin status
     * @return View
     */
    public function index() : View
    {
        return view('servers.serverKeyManagement', [
            'servers' => Server::orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * View server for editing
     * @param Server $server
     * @param Ssh $ssh
     * @return View
     */
    public function listServerKeys(Server $server, Ssh $ssh) : View
    {
        return view('servers.listServerKeys', [
            'server' => $server,
            'keys' => $ssh->getAuthorizedKeys($server),
        ]);
    }

    /**
     * Add authorized key
     * @param Ssh $ssh
     * @return RedirectResponse
     */
    public function addAuthorizedKey(Ssh $ssh) : RedirectResponse
    {
        return $this->addRemoveAuthorizedKey($ssh, 'add');
    }

    /**
     * View server for editing
     * @param Ssh $ssh
     * @return RedirectResponse
     */
    public function removeAuthorizedKey(Ssh $ssh) : RedirectResponse
    {
        return $this->addRemoveAuthorizedKey($ssh, 'remove');
    }

    /**
     * View server for editing
     * @param Ssh $ssh
     * @param string $action
     * @return RedirectResponse
     */
    private function addRemoveAuthorizedKey(Ssh $ssh, $action) : RedirectResponse
    {
        // Get the key
        $key = request('key');

        // If there is no key, return an error
        if (! $key) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                ['The "Key" field is required'],
                'danger',
                true
            );

            // Redirect back
            return redirect('/servers/server-key-management');
        }

        // Get server params
        $allServers = request('allServers');
        $servers = request('servers') ?? [];

        // Get servers
        $serverCollection = null;
        if ($allServers) {
            $serverCollection = Server::all();
        } elseif ($servers) {
            $serverCollection = Server::whereIn('id', $servers)->get();
        }

        if (! $serverCollection) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                ['You must specify servers'],
                'danger',
                true
            );

            // Redirect back
            return redirect('/servers/server-key-management');
        }

        // Iterate through server collection and perform action
        $serverCollection->each(function ($server) use ($ssh, $key, $action) {
            /** @var Server $server */
            // Add the key if action is add
            if ($action === 'add') {
                $ssh->addAuthorizedKey($server, $key);
                return;
            }

            // Delete the key
            $ssh->removeAuthorizedKey($server, $key);
        });

        // Put server names in array
        $serverNameArray = [];
        foreach ($serverCollection as $server) {
            $serverNameArray[] = $server->name;
        }

        // Set message
        $message = 'The specified key was ';
        if ($action === 'add') {
            $message .= 'added';
        }
        $message .= 'successfully on the following servers:';

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            $message,
            $serverNameArray,
            'success',
            true
        );

        // Redirect back
        return redirect('/servers/server-key-management');
    }
}
