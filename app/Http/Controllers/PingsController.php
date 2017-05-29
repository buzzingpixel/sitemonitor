<?php

namespace App\Http\Controllers;

use App\Ping;
use App\Service\Messages;
use Illuminate\Database\Eloquent\Collection;

/**
 * Class PingsController
 */
class PingsController extends Controller
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
        $this->middleware('CheckPrivileges');
    }

    /**
     * Show users and admin status
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('pings', [
            'pings' => Ping::orderBy('name', 'asc')->get(),
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }

    /**
     * Create a new ping
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function create()
    {
        // Set post values
        $this->postValues['name'] = request('name');
        $this->postValues['expect_every'] = request('expect_every');
        $this->postValues['warn_after'] = request('warn_after');

        // Cast values
        $name = (string) $this->postValues['name'];
        $expectEvery = (int) $this->postValues['expect_every'];
        $warnAfter = (int) $this->postValues['warn_after'];

        // Make sure we have name and urls
        if (! $name || ! $expectEvery || ! $warnAfter) {
            // Set name error
            if (! $name) {
                $this->postErrors['name'] = 'The "Ping Name" field is required';
            }

            // Set expect_every error
            if (! $expectEvery) {
                $this->postErrors['expect_every'] = 'You must specify in minutes how often to expect this ping';
            }

            // Set warn_after error
            if (! $warnAfter) {
                $this->postErrors['warn_after'] =
                    'You must specify in minutes when to warn after not hearing from ping';
            }

            // Add an error message
            if (count($this->postErrors) > 0) {
                Messages::addMessage(
                    'postErrors',
                    'There were errors with your submission',
                    $this->postErrors,
                    'danger'
                );
            }

            // Return the view
            return $this->index();
        }

        // Create a monitored site model
        $ping = new Ping();

        // Add name
        $ping->name = $name;

        // Add expect_every
        $ping->setMinutes('expect_every', $expectEvery);

        // Add warn_after
        $ping->setMinutes('warn_after', $warnAfter);

        // Save the monitored site
        $ping->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$ping->name} was added successfully",
            'success',
            true
        );

        // Redirect to the sites page
        return redirect('/pings');
    }

    /**
     * View ping for editing
     * @param Ping $ping
     * @return \Illuminate\Http\Response
     */
    public function view(Ping $ping)
    {
        $this->postValues['name'] = isset($this->postValues['name']) ?
            $this->postValues['name'] :
            $ping->name;

        $this->postValues['expect_every'] = isset($this->postValues['expect_every']) ?
            $this->postValues['expect_every'] :
            $ping->getMinutes('expect_every');

        $this->postValues['warn_after'] = isset($this->postValues['warn_after']) ?
            $this->postValues['warn_after'] :
            $ping->getMinutes('warn_after');

        return view('pings', [
            'pings' => new Collection(),
            'editPing' => $ping,
            'postErrors' => $this->postErrors,
            'postValues' => $this->postValues
        ]);
    }

    /**
     * Edit ping
     * @param Ping $ping
     * @return \Illuminate\Http\Response|\Illuminate\Routing\Redirector|\Illuminate\Http\RedirectResponse
     */
    public function edit(Ping $ping)
    {
        // Set post values
        $this->postValues['name'] = request('name');
        $this->postValues['expect_every'] = request('expect_every');
        $this->postValues['warn_after'] = request('warn_after');

        // Cast values
        $name = (string) $this->postValues['name'];
        $expectEvery = (int) $this->postValues['expect_every'];
        $warnAfter = (int) $this->postValues['warn_after'];

        // Make sure we have name and urls
        if (! $name || ! $expectEvery || ! $warnAfter) {
            // Set name error
            if (! $name) {
                $this->postErrors['name'] = 'The "Ping Name" field is required';
            }

            // Set expect_every error
            if (! $expectEvery) {
                $this->postErrors['expect_every'] = 'You must specify in minutes how often to expect this ping';
            }

            // Set warn_after error
            if (! $warnAfter) {
                $this->postErrors['warn_after'] =
                    'You must specify in minutes when to warn after not hearing from ping';
            }

            // Add an error message
            if (count($this->postErrors) > 0) {
                Messages::addMessage(
                    'postErrors',
                    'There were errors with your submission',
                    $this->postErrors,
                    'danger'
                );
            }

            // Return the view
            return $this->view($ping);
        }

        // Add name
        $ping->name = $name;

        // Add expect_every
        $ping->setMinutes('expect_every', $expectEvery);

        // Add warn_after
        $ping->setMinutes('warn_after', $warnAfter);

        // Save the monitored site
        $ping->save();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$ping->name} was saved successfully",
            'success',
            true
        );

        // Redirect to the sites page
        return redirect('/pings');
    }

    /**
     * Delete ping
     * @param Ping $ping
     * @return \Illuminate\Http\Response
     */
    public function delete(Ping $ping)
    {
        // Delete the ping
        $ping->delete();

        // Add a success message
        Messages::addMessage(
            'postSuccess',
            'Success!',
            "{$ping->name} was deleted successfully",
            'success',
            true
        );

        // Redirect to the pings page
        return redirect('/pings');
    }
}
