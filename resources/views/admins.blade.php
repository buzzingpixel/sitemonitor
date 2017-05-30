<?php

/** @var \Illuminate\Database\Eloquent\Collection $users */

?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if ($users->count())
                    <form method="POST" action="/admins">
                        {{ csrf_field() }}
                        <div class="panel panel-default">
                            <div class="panel-heading">User Privileges</div>

                            <div class="panel-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Login Email</th>
                                        <th>Access Sites</th>
                                        <th>Access Pings</th>
                                        <th>Access Notifications</th>
                                        <th>Access Admins</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach ($users as $user)
                                        <?php /** @var \App\User $user */ ?>

                                        <tr>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            <td>
                                                <input type="hidden" name="users[{{ $user->id }}][access_sites]" value="0">
                                                <input
                                                    type="checkbox"
                                                    name="users[{{ $user->id }}][access_sites]"
                                                    value="1"
                                                    @if ($user->access_sites)
                                                    checked
                                                    @endif
                                                >
                                            </td>
                                            <td>
                                                <input type="hidden" name="users[{{ $user->id }}][access_pings]" value="0">
                                                <input
                                                    type="checkbox"
                                                    name="users[{{ $user->id }}][access_pings]"
                                                    value="1"
                                                    @if ($user->access_pings)
                                                    checked
                                                    @endif
                                                >
                                            </td>
                                            <td>
                                                <input type="hidden" name="users[{{ $user->id }}][access_notifications]" value="0">
                                                <input
                                                    type="checkbox"
                                                    name="users[{{ $user->id }}][access_notifications]"
                                                    value="1"
                                                    @if ($user->access_notifications)
                                                    checked
                                                    @endif
                                                >
                                            </td>
                                            <td>
                                                <input type="hidden" name="users[{{ $user->id }}][access_admins]" value="0">
                                                <input
                                                    type="checkbox"
                                                    name="users[{{ $user->id }}][access_admins]"
                                                    value="1"
                                                    @if ($user->access_admins)
                                                    checked
                                                    @endif
                                                >
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update User Privileges</button>
                                </div>
                            </div>
                        </div>
                    </form>
                @endif

            </div>
        </div>
    </div>
@endsection
