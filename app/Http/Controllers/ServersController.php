<?php

namespace App\Http\Controllers;

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
            'servers' => [],
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }
}
