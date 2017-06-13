<?php

namespace App\Http\Controllers;

use Illuminate\Support\Collection;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Server;
use App\Service\Ssh;
use App\Service\Messages;
use App\ServerGroup;

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
            'servers' => new Collection(),
            'serverGroups' => ServerGroup::orderBy('name', 'asc')->get(),
            'unGroupedServers' => Server::doesntHave('serverGroup')
                ->orderBy('name', 'asc')
                ->get(),
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
        $keys = $ssh->getAuthorizedKeys($server);

        $error = false;

        if (is_string($keys) || $keys === false) {
            if ($keys === 'noKey') {
                $error = 'There is no key for this server and you have not selected a default key';
            } elseif ($keys === 'badCredentials') {
                $error = 'The username or key for this server is incorrect';
            } elseif ($keys === 'cannotConnect') {
                $error = 'Could not establish connection';
            } else {
                $error = 'An unknown error occurred';
            }
        }

        if ($error) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'The following error was encountered',
                $error,
                'danger'
            );
        }

        return view('servers.listServerKeys', [
            'server' => $server,
            'keys' => (is_string($keys) || $keys === false) ? new Collection() : $keys,
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

        // Array for errors
        $errors = new \stdClass();
        $errors->items = [];

        // Successful servers
        $success = new \stdClass();
        $success->items = [];

        // Iterate through server collection and perform action
        $serverCollection->each(function ($server) use ($ssh, $key, $action, $errors, $success) {
            /** @var Server $server */
            // Add the key if action is add
            if ($action === 'add') {
                $response = $ssh->addAuthorizedKey($server, $key);
            } else {
                // Delete the key
                $response = $ssh->removeAuthorizedKey($server, $key);
            }

            if ($response === 'noKey') {
                $errors->items[] = "{$server->name}: There is no key for this server and you have not selected a default key";
            } elseif ($response === 'badCredentials') {
                $errors->items[] = "{$server->name}: The username or key for this server is incorrect";
            } elseif ($response === 'cannotConnect') {
                $errors->items[] = "{$server->name}: Could not establish connection";
            } elseif ($response === false) {
                $errors->items[] = "{$server->name}: An unknown error occurred";
            } else {
                $success->items[] = $server->name;
            }
        });

        if ($success->items) {
            // Set message
            $message = 'The specified key was ';
            if ($action === 'add') {
                $message .= 'added';
            } else {
                $message .= 'deleted';
            }
            $message .= ' successfully on the following servers:';

            // Add a success message
            Messages::addMessage(
                'postSuccess',
                $message,
                $success->items,
                'success',
                true
            );
        }

        if ($errors->items) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'The following errors were encountered',
                $errors->items,
                'danger',
                true
            );
        }

        // Redirect back
        return redirect('/servers/server-key-management');
    }
}
