<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use App\Service\Messages;
use Illuminate\Http\RedirectResponse;
use App\ScriptSet;
use App\Script;

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
     * @return RedirectResponse
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

        // Redirect to the scripts page
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

    /**
     * Update set
     * @param ScriptSet $scriptSet
     * @return RedirectResponse
     */
    public function updateSet(ScriptSet $scriptSet) : RedirectResponse
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
            return redirect("/servers/scripts/{$scriptSet->id}");
        }

        // Set the name
        $scriptSet->name = $setName;

        // Save the script set
        $scriptSet->save();

        // Get scripts
        $scripts = request('scripts');
        $scripts = is_array($scripts) ? $scripts : [];

        // Iterate through scripts and send to method to save
        foreach ($scripts as $script) {
            $this->saveScript($script, $scriptSet->id);
        }

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$setName} was updated successfully",
            'success',
            true
        );

        // Redirect to the scripts page
        return redirect('/servers/scripts');
    }

    /** @var int $runningPosition */
    private $runningPosition = 1;

    /**
     * Save script
     * @param array $script
     * @param int $setId
     * @throws \Exception
     */
    private function saveScript(array $script, int $setId)
    {
        // Get existing script if applicable
        $scriptModel = null;
        if ($script['scriptId']) {
            $scriptModel = Script::where('id', $script['scriptId'])->first();
        }

        /** @var Script $scriptModel */

        // Delete script if needed
        if ($scriptModel && $script['scriptDelete'] === 'true') {
            $scriptModel->delete();
            return;
        }

        // If there is no scriptModel, make one
        $scriptModel = $scriptModel ?? new Script();

        // Set properties on the model
        $scriptModel->fill([
            'script_set_id' => $setId,
            'position' => $this->runningPosition,
            'name' => $script['scriptName'] ?? '',
            'content' => $script['scriptContent'] ?? '',
        ]);

        // Save the script model
        $scriptModel->save();

        // Increment the running position
        $this->runningPosition++;
    }
}
