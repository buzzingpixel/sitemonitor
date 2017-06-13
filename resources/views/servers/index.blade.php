<?php

/** @var \Illuminate\Database\Eloquent\Collection $serverGroups */
/** @var \Illuminate\Database\Eloquent\Collection $unGroupedServers */
/** @var array $serverInputs */

$pageTitle = 'Servers';
if (isset($editServer)) {
    $pageTitle = "Editing {$editServer->name}";
}

?>

@extends('servers.layout')

@section('serverContent')

    @if (isset($editServer))
    <a href="/servers">&laquo; Back to servers</a><br><br>
    @endif

    @if ($serverGroups->count())
        @foreach ($serverGroups as $serverGroup)
            @if ($serverGroup->servers->count())
                <?php /** @var \App\ServerGroup $serverGroup */ ?>
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $serverGroup->name }}</div>
                    <div class="panel-body u-overflow-scroll">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Address</th>
                                <th>Port</th>
                                <th>Username</th>
                                <th></th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach ($serverGroup->servers as $server)
                                <?php /** @var \App\Server $server */ ?>
                                <tr>
                                    <td>{{ $server->name }}</td>
                                    <td>{{ $server->address }}</td>
                                    <td>{{ $server->port }}</td>
                                    <td>{{ $server->username }}</td>
                                    <td><a href="/servers/{{ $server->id }}">Edit</a></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        @endforeach
    @endif

    @if ($unGroupedServers->count())
        <div class="panel panel-default">
            <div class="panel-heading">Un-grouped</div>
            <div class="panel-body u-overflow-scroll">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th>Address</th>
                        <th>Port</th>
                        <th>Username</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($unGroupedServers as $server)
                        <?php /** @var \App\Server $server */ ?>
                        <tr>
                            <td>{{ $server->name }}</td>
                            <td>{{ $server->address }}</td>
                            <td>{{ $server->port }}</td>
                            <td>{{ $server->username }}</td>
                            <td><a href="/servers/{{ $server->id }}">Edit</a></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <div class="panel panel-default">
        <div class="panel-heading">
            @if (isset($editServer))
                Editing Server: {{ $editServer->name }}
            @else
                Add a Server
            @endif
        </div>
        <div class="panel-body">
            <form
                method="POST"
                @if (isset($editServer))
                action="/servers/{{$editServer->id}}"
                @else
                action="/servers"
                @endif
            >
                {{ csrf_field() }}
                @foreach ($serverInputs as $input)
                    @include($input['view'])
                @endforeach
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">
                        @if (isset($editServer))
                            Save Server
                        @else
                            Add Server
                        @endif
                    </button>
                </div>
            </form>
            @if (isset($editServer))
                <br>
                <form method="POST" action="/servers/delete/{{ $editServer->id }}">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Delete Server</button>
                    </div>
                </form>
            @endif
        </div>
    </div>

@endsection
