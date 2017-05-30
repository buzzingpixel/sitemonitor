<?php

/** @var \App\User $user */

?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if ($user->sshKeys->count())
                    <div class="panel panel-default">
                        <div class="panel-heading">SSH Keys</div>

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Key Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($user->sshKeys as $sshKey)
                                        <?php /** @var \App\SshKey $sshKey */ ?>

                                        <tr>
                                            <td>{{ $sshKey->name }}</td>
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
                                    placeholder="MyKey.pub"
                                    @if (isset($postValues['name']))
                                    value="{{ $postValues['name'] }}"
                                    @endif
                                >
                                @if (isset($postErrors['name']))
                                    <span class="error text-danger">{{ $postErrors['name'] }}</span>
                                @endif
                            </div>
                            <div class="form-group @if (isset($postErrors['key'])) has-error @endif">
                                <label for="key">Public Key</label>
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

            </div>
        </div>
    </div>
@endsection
