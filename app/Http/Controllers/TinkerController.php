<?php

namespace App\Http\Controllers;

use App\Server;
use App\SshKey;
use App\User;

/**
 * Class TinkerController
 */
class TinkerController extends Controller
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:tinker');
    }

    /**
     * Index
     */
    public function index()
    {
        $sshKey = SshKey::first();

        dd($sshKey->sshServerUserKeys);

        $user = User::first();

        dd($user->sshServerUserKeys);

        $server = Server::first();

        dd($server->sshServerUserKeys->first()->sshKey->key);

        // $ssh = new \phpseclib\Net\SSH2('192.241.158.82');
        // $sshKey = \App\SshKey::first();
        // $key = new \phpseclib\Crypt\RSA();
        // $key->loadKey($sshKey->key);
        // $status = $ssh->login('dwg', $key);
        //
        // if (! $status) {
        //     if ($ssh->isConnected()) {
        //         dd('Bad username or password/key');
        //     }
        //
        //     dd('Unable to establish a connection');
        // }
        //
        // dd($ssh->exec('ls -la'));
    }
}
