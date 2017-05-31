<?php

namespace App\Http\Controllers;

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
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:tinker');
    }

    /**
     * Index
     */
    public function index()
    {
        $ssh = new \phpseclib\Net\SSH2('192.241.158.82');
        $sshKey = \App\SshKey::first();
        $key = new \phpseclib\Crypt\RSA();
        $key->loadKey($sshKey->key);
        $status = $ssh->login('dwg', $key);

        if (! $status) {
            if ($ssh->isConnected()) {
                dd('Bad username or password/key');
            }

            dd('Unable to establish a connection');
        }

        dd($ssh->exec('ls -la'));
    }
}
