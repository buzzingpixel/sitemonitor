<?php

/** @var \App\User $user */
$timezone = new \Camroncade\Timezone\Timezone;

?>

@extends('user.layout', [
    'pageTitle' => 'User Settings'
])

@section('innerContent')

    <div class="panel panel-default">
        <div class="panel-heading">General Settings</div>

        <div class="panel-body">
            <form method="POST" action="/settings" class="form-horizontal">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="timezone" class="col-md-4 control-label">Timezone</label>
                    <div class="col-md-6">
                        {!! $timezone->selectForm(Auth::user()->timezone, null, [
                            'class' => 'form-control',
                            'name' => 'timezone'
                        ]) !!}
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-md-6 col-md-offset-4">
                        <button type="submit" class="btn btn-primary">Update Settings</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @if ($user->sshKeys->count())
        <div class="panel panel-default">
            <div class="panel-heading">SSH Keys</div>

            <div class="panel-body u-overflow-scroll js-filter-table">
                <input type="text" class="form-control js-filter-table__input" placeholder="Filter">
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

                            <tr class="@if ($sshKey->is_default) info @endif js-filter-table__row">
                                <td>{{ $sshKey->name }}</td>
                                <td>
                                    @if ($sshKey->is_default)
                                        &#x1f44d;
                                    @else
                                        <a class="btn btn-default" href="/settings/make-default-ssh-key/{{ $sshKey->id }}">
                                            Make Default
                                        </a>
                                    @endif
                                </td>
                                <td>
                                    <a class="btn btn-default btn-danger" href="/settings/delete-ssh-key/{{ $sshKey->id }}">
                                        Delete
                                    </a>
                                </td>
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
