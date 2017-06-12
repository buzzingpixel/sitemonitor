<?php

namespace App\Http\Controllers;

use App\Server;
use App\SshKey;
use App\SshServerUserKey;
use Illuminate\Contracts\Auth\Guard;
use App\User;

/**
 * Class ServersSshUserKeysController
 */
class ServersSshUserKeysController extends Controller
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
     * @param Guard $auth
     * @return \Illuminate\Http\Response
     */
    public function index(Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        return view('servers.sshUserKeys', [
            'servers' => Server::orderBy('name', 'asc')->get(),
            'sshKeys' => SshKey::where('user_id', $currentUser->id)->orderBy('name', 'asc')->get(),
        ]);
    }

    /**
     * Update
     * @param Guard $auth
     * @throws \Exception
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update(Guard $auth)
    {
        /** @var User $currentUser */
        $currentUser = $auth->user();

        $keys = is_array(request('keys')) ? request('keys') : [];

        // Iterate through posted keys
        foreach ($keys as $serverId => $keyId) {
            // Get existing server user key
            /** @var SshServerUserKey $serverUserKey */
            $serverUserKey = SshServerUserKey::where('user_id', $currentUser->id)
                ->where('server_id', $serverId)
                ->first();

            // If the key is set to default
            if ($keyId === 'default') {
                // If there is no key, move on
                if (! $serverUserKey) {
                    continue;
                }

                // Delete the key
                $serverUserKey->delete();
                continue;
            }

            // If there is no key, we need to make one
            if (! $serverUserKey) {
                $serverUserKey = new SshServerUserKey();
            }

            // Fill and save the model
            $serverUserKey->fill([
                'user_id' => $currentUser->id,
                'ssh_key_id' => $keyId,
                'server_id' => $serverId
            ])->save();
        }

        // Redirect to the servers page
        return redirect('/servers/user-server-keys');
    }
}
