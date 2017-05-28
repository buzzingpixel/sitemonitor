<?php

/** @var \Illuminate\Database\Eloquent\Collection $notificationEmails */
/** @var array $postErrors */
/** @var array $postValues */

?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Notification Emails</div>

                    @if ($notificationEmails->count())

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Email Address</th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($notificationEmails as $notificationEmail)
                                        <?php /** @var \App\NotificationEmail $notificationEmail */ ?>

                                        <tr>
                                            <td>{{ $notificationEmail->email }}</td>
                                            <td><a href="/notifications/delete/{{ $notificationEmail->id }}">Delete</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Add Email Address</div>

                    <div class="panel-body">
                        <form method="POST" action="/notifications">
                            {{ csrf_field() }}
                            <div class="form-group @if (isset($postErrors['email'])) has-error @endif">
                                <label for="email">Email</label>
                                <input
                                    type="email"
                                    name="email"
                                    id="email"
                                    class="form-control"
                                    placeholder="name@site.com"
                                    @if (isset($postValues['email']))
                                    value="{{ $postValues['email'] }}"
                                    @endif
                                >
                                @if (isset($postErrors['email']))
                                    <span class="error text-danger">{{ $postErrors['email'] }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Email</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
