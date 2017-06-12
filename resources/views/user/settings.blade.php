<?php

/** @var \App\User $user */

?>

@extends('user.layout', [
    'pageTitle' => 'User Settings'
])

@section('innerContent')

    @if ($user->sshKeys->count())
        <div class="panel panel-default">
            <div class="panel-heading">SSH Keys</div>

            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Key Name</th>
                            <th>Default</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($user->sshKeys as $sshKey)
                            <?php /** @var \App\SshKey $sshKey */ ?>

                            <tr class="@if ($sshKey->is_default) info @endif">
                                <td>{{ $sshKey->name }}</td>
                                <td>
                                    @if ($sshKey->is_default)
                                        &#x1f44d;
                                    @else
                                        <a href="/settings/make-default-ssh-key/{{ $sshKey->id }}">Make Default</a>
                                    @endif
                                </td>
                                <td><a href="/settings/delete-ssh-key/{{ $sshKey->id }}">Delete</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">Add an SSH Key</div>

        <div class="panel-body">
            <form method="POST" action="/settings/add-ssh-key">
                {{ csrf_field() }}
                <div class="form-group @if (isset($postErrors['name'])) has-error @endif">
                    <label for="name">Name</label>
                    <input
                        type="text"
                        name="name"
                        id="name"
                        class="form-control"
                        placeholder="MyKey"
                        @if (isset($postValues['name']))
                        value="{{ $postValues['name'] }}"
                        @endif
                    >
                    @if (isset($postErrors['name']))
                        <span class="error text-danger">{{ $postErrors['name'] }}</span>
                    @endif
                </div>
                <div class="form-group @if (isset($postErrors['key'])) has-error @endif">
                    <label for="key">Private Key</label>
                    <textarea
                        name="key"
                        id="key"
                        rows="10"
                        class="form-control"
                    ></textarea>
                    @if (isset($postErrors['key']))
                        <span class="error text-danger">{{ $postErrors['key'] }}</span>
                    @endif
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add SSH Key</button>
                </div>
            </form>
        </div>
    </div>

@endsection
