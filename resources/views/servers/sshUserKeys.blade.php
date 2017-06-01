<?php

/** @var \Illuminate\Database\Eloquent\Collection $servers */
/** @var \Illuminate\Database\Eloquent\Collection $sshKeys */

?>

@extends('servers.layout')

@section('serverContent')

    @if ($servers->count())
        <form method="POST" action="/servers/user-server-keys">
            {{ csrf_field() }}
            <div class="panel panel-default">
                <div class="panel-heading">SSH Key Server Association</div>
                <div class="panel-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Server Name</th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($servers as $server)
                            <?php /** @var \App\Server $server */ ?>
                            <tr>
                                <td>{{ $server->name }}</td>
                                <td>
                                    <select name="keys[{{ $server->id  }}]">
                                        <option value="default">Default Key</option>
                                        @foreach($sshKeys as $sshKey)
                                            <?php /** @var \App\SshKey $sshKey */ ?>
                                                <option
                                                    value="{{$sshKey->id}}"
                                                    @if ($server->sshServerUserKeys()->where('ssh_key_id', $sshKey->id)->count())
                                                    selected
                                                    @endif
                                                >
                                                    {{ $sshKey->name }}
                                                </option>
                                        @endforeach
                                    </select>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </div>
            </div>
        </form>
    @endif

@endsection
