<?php

namespace App\Http\Controllers;

use App\ServerGroup;
use App\Service\Messages;

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
        (new ServerGroup([
            'name' => request('groupName')
        ]))->save();

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
}
