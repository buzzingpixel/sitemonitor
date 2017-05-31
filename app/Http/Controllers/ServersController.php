<?php

namespace App\Http\Controllers;

use App\Server;
use App\Service\Messages;

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
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:servers');
    }

    /**
     * Index
     */
    public function index()
    {
        return view('servers.index', [
            'servers' => Server::orderBy('name', 'asc')->get(),
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
}
