<?php

namespace App\Http\Controllers;

use App\Server;
use App\Service\Messages;
use Illuminate\Database\Eloquent\Collection;
use App\ServerGroup;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class ServersController
 */
class ServersController extends Controller
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
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:servers');
    }

    /**
     * Index
     */
    public function index()
    {
        return view('servers.index', [
            'serverGroups' => ServerGroup::orderBy('name', 'asc')->get(),
            'unGroupedServers' => Server::doesntHave('serverGroup')
                ->orderBy('name', 'asc')
                ->get(),
            'serverInputs' => Server::$inputs,
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }

    /**
     * Create server
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Iterate through Server inputs
        foreach (Server::$inputs as $input) {
            // Set post value
            $this->postValues[$input['name']] = request($input['name']);

            // Check if required and set error if not present
            if (isset($input['required']) &&
                $input['required'] &&
                ! $this->postValues[$input['name']]
            ) {
                $this->postErrors[$input['name']] =
                    'The "' . $input['title'] . ' " field is required';
            }
        }

        // If there are post errors, show them
        if (count($this->postErrors)) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                $this->postErrors,
                'danger'
            );

            // Return the view
            return $this->index();
        }

        // Create and save a server model
        (new Server($this->postValues))->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$this->postValues['name']} was added successfully",
            'success',
            true
        );

        // Redirect to the servers page
        return redirect('/servers');
    }

    /**
     * View server for editing
     * @param Server $server
     * @return \Illuminate\Http\Response
     */
    public function view(Server $server)
    {
        // Set values
        foreach (Server::$inputs as $input) {
            $this->postValues[$input['name']] =
                $this->postValues[$input['name']] ?? $server->{$input['name']};
        }

        return view('servers.index', [
            'servers' => new Collection(),
            'serverInputs' => Server::$inputs,
            'editServer' => $server,
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }

    /**
     * Edit server
     * @param Server $server
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function edit(Server $server)
    {
        // Iterate through Server inputs
        foreach (Server::$inputs as $input) {
            // Set post value
            $this->postValues[$input['name']] = request($input['name']);

            // Check if required and set error if not present
            if (isset($input['required']) &&
                $input['required'] &&
                ! $this->postValues[$input['name']]
            ) {
                $this->postErrors[$input['name']] =
                    'The "' . $input['title'] . ' " field is required';
            }
        }

        // If there are post errors, show them
        if (count($this->postErrors)) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                $this->postErrors,
                'danger'
            );

            // Return the view
            return $this->view($server);
        }

        // Fill server values and save
        $server->fill($this->postValues)->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$this->postValues['name']} was saved successfully",
            'success',
            true
        );

        // Redirect to the servers page
        return redirect('/servers');
    }

    /**
     * Delete Server
     *
     * @param Server $server
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function delete(Server $server)
    {
        // Delete the server
        $server->delete();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$server->name} was deleted successfully",
            'success',
            true
        );

        // Redirect to servers
        return redirect('/servers');
    }
}
