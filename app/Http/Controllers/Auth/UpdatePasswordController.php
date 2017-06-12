<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use App\Service\Messages;

/**
 * Class UpdatePasswordController
 */
class UpdatePasswordController extends Controller
{
    /**
     * UpdatePasswordController constructor
     */
    public function __construct()
    {
        parent::__construct();
        $this->middleware('auth');
    }

    /**
     * Index
     */
    public function index()
    {
        return view('user.updatePassword');
    }

    /**
     * Update the password
     * @param Request $request
     * @return RedirectResponse
     * @throws \Exception
     */
    public function update(Request $request) : RedirectResponse
    {
        // Validate request
        $this->validate($request, [
            'old' => 'required',
            'password' => 'required|min:6|confirmed',
        ]);

        // Get the user
        $user = User::find(Auth::id());

        // Get hashed password
        $hashedPassword = $user->password;

        // If checks pass
        if (Hash::check($request->old, $hashedPassword)) {
            // Change the password
            $user->fill([
                'password' => Hash::make($request->password)
            ])->save();

            // Add a success message
            Messages::addMessage(
                'postSuccess',
                'Success!',
                'Your password has been changed',
                'success',
                true
            );

            // Return
            return back();
        }

        // Add error message
        Messages::addMessage(
            'postErrors',
            'There were errors with your submission',
            'Your password did not meet the requirements and has not been changed',
            'danger'
        );

        // Return
        return back();
    }
}
