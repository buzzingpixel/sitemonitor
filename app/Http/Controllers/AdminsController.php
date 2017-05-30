<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Contracts\Auth\Guard;
use App\Service\Messages;

/**
 * Class AdminsController
 */
class AdminsController extends Controller
{
    /**
     * Create a new controller instance
     */
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('CheckPrivileges:admins');
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

        return view('admins', [
            'users' => User::where('id', '!=', $currentUser->id)->get()
        ]);
    }

    /**
     * Update users
     * @return \Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function update()
    {
        // Get users from post
        $users = request('users');

        // Make sure it's an array
        if (! is_array($users)) {
            $users = array();
        }

        foreach ($users as $userId => $userInput) {
            /** @var User $user */
            $user = User::where('id', $userId)->first();
            $user->is_admin = $userInput['is_admin'];
            $user->save();
        }

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            'User privileges have been updated successfully',
            'success',
            true
        );

        // Redirect to the dashboard
        return redirect('/admins');
    }
}
