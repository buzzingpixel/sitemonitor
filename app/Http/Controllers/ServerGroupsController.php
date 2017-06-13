<?php

namespace App\Http\Controllers;

use App\ServerGroup;
use App\Service\Messages;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class ServerGroupsController
 */
class ServerGroupsController extends Controller
{
    /**
     * Create server group
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Get the group name
        $groupName = request('groupName');

        // Make sure there is a group name
        if (! $groupName) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                'A Group Name is require ',
                'danger',
                true
            );

            // Redirect to the servers page
            return redirect('/servers');
        }

        // Create and save a server group model
        (new ServerGroup(['name' => $groupName]))->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$groupName} was added successfully",
            'success',
            true
        );

        // Redirect to the servers page
        return redirect('/servers');
    }

    /**
     * View server group for editing
     * @param ServerGroup $serverGroup
     * @return \Illuminate\Http\Response
     */
    public function view(ServerGroup $serverGroup)
    {
        return view('servers.index', [
            'serverGroups' => ServerGroup::orderBy('name', 'asc')->get(),
            'unGroupedServers' => new Collection(),
            'editServerGroup' => $serverGroup
        ]);
    }

    /**
     * Edit server group
     * @param ServerGroup $serverGroup
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function edit(ServerGroup $serverGroup)
    {
        // Get the group name
        $groupName = request('groupName');

        // Make sure there is a group name
        if (! $groupName) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                'A Group Name is require ',
                'danger',
                true
            );

            // Redirect to the servers page
            return redirect('/servers');
        }

        // Set the name
        $serverGroup->name = $groupName;

        // Save the server group
        $serverGroup->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$groupName} was saved successfully",
            'success',
            true
        );

        // Redirect to the servers page
        return redirect('/servers');
    }
}
