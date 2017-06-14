<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Service\Messages;
use Illuminate\Http\RedirectResponse;
use App\ScriptSet;

/**
 * Class ScriptsController
 */
class ScriptsController extends Controller
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
     * Index
     * @return View
     */
    public function index() : View
    {
        return view('servers.scripts', [
            'scriptSets' => ScriptSet::orderBy('created_at', 'desc')->get()
        ]);
    }

    /**
     * Add set
     * @return RedirectResponse;
     */
    public function addSet() : RedirectResponse
    {
        // Get the set name
        $setName = request('setName');

        // Make sure there is a group name
        if (! $setName) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                'A Set Name is require ',
                'danger',
                true
            );

            // Redirect to the servers page
            return redirect('/servers/scripts');
        }

        // Create and save a ScriptSet model
        (new ScriptSet(['name' => $setName]))->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$setName} was added successfully",
            'success',
            true
        );

        // Redirect to the servers page
        return redirect('/servers/scripts');
    }

    /**
     * View set
     * @param ScriptSet $scriptSet
     * @return View
     */
    public function viewSet(ScriptSet $scriptSet): View
    {
        return view('servers.viewScriptSet', [
            'scriptSet' => $scriptSet
        ]);
    }
}
