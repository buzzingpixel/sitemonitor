<?php

namespace App\Http\Controllers;

/**
 * Class RemindersController
 */
class RemindersController extends Controller
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:reminders');
    }

    /**
     * Index
     */
    public function index()
    {
        return view('reminders.index');
    }
}
