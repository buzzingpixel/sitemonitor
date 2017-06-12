<?php

namespace App\Http\Controllers;

use App\SshKey;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use App\Service\Messages;

/**
 * Class SettingsController
 */
class SettingsController extends Controller
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
    }

    /**
     * Show users and admin status
     * @param Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function index(Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        return view('user.settings', [
            'user' => $currentUser,
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }

    /**
     * Add SSH Key
     * @param Guard $auth
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function addSshKey(Guard $auth)
    {
        // Set post values
        $this->postValues['name'] = request('name');
        $this->postValues['key'] = request('key');

        // Make sure name is set
        if (! $this->postValues['name']) {
            // Set error
            $this->postErrors['name'] = 'The "Name" field is required';
        }

        // Make sure key is set
        if (! $this->postValues['key']) {
            // Set error
            $this->postErrors['key'] = 'The "Key" field is required';
        }

        // Check for errors
        if (count($this->postErrors)) {
            // Add an error message
            Messages::addMessage(
                'postErrors',
                'There were errors with your submission',
                $this->postErrors,
                'danger'
            );

            // Return the view
            return $this->index($auth);
        }

        /** @var User $currentUser */
        $currentUser = $auth->user();

        // Create an SSH Key model
        $sshKey = new SshKey();
        $sshKey->user_id = $currentUser->id;
        $sshKey->name = $this->postValues['name'];
        $sshKey->key = $this->postValues['key'];

        // Save the KEY
        $sshKey->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "The SSH key {$sshKey->name} was added successfully",
            'success',
            true
        );

        // Redirect to settings
        return redirect('/settings');
    }

    /**
     * Delete ssh key
     * @param SshKey $sshKey
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function deleteSshKey(SshKey $sshKey)
    {
        // Delete the site
        $sshKey->delete();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "The SSH key {$sshKey->name} was deleted successfully",
            'success',
            true
        );

        // Redirect to settings
        return redirect('/settings');
    }

    /**
     * Make SSH Key Default
     * @param SshKey $sshKey
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function makeSshKeyDefault(SshKey $sshKey)
    {
        // Remove existing default
        SshKey::query()->where('is_default', 1)->update([
            'is_default' => 0
        ]);

        // Set key as default
        $sshKey->is_default = true;

        // Save the key
        $sshKey->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "The SSH key {$sshKey->name} was made the default",
            'success',
            true
        );

        // Redirect to settings
        return redirect('/settings');
    }
}
