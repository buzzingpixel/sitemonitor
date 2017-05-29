<?php

namespace App\Http\Controllers;

use App\User;
use App\Service\Messages;

/**
 * Class PingsController
 */
class PingsController extends Controller
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPrivileges');
    }

    /**
     * Show users and admin status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pings');
    }
}
