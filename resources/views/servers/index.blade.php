<?php

/** @var \Illuminate\Database\Eloquent\Collection $serverGroups */
/** @var \Illuminate\Database\Eloquent\Collection $unGroupedServers */
/** @var array $serverInputs */

$pageTitle = 'Servers';
if (isset($editServer)) {
    $pageTitle = "Editing {$editServer->name}";
} elseif (isset($editServerGroup)) {
    $pageTitle = "Editing Server Group {$editServerGroup->name}";
}

?>

@extends('servers.layout')

@section('serverContent')

    @if (isset($editServer) || isset($editServerGroup))
        <ol class="breadcrumb u-background-white">
            <li><a href="/servers">Server Index</a></li>
            @if (isset($editServer))
                <li class="active">Editing Server: {{ $editServer->name }}</li>
            @elseif (isset($editServerGroup))
                <li class="active">Editing Server Group: {{ $editServerGroup->name }}</li>
            @endif
        </ol>
    @endif

    @if (! isset($editServerGroup) && ! isset($editServer))
        @if ($serverGroups->count())
            @foreach ($serverGroups as $serverGroup)
                @if ($serverGroup->servers->count())
                    <?php /** @var \App\ServerGroup $serverGroup */ ?>
                    <div class="panel panel-default">
                        <div
                            class="panel-heading"
                        >
                            {{ $serverGroup->name }} (<a href="/servers/edit-group/{{ $serverGroup->id }}">edit</a>)
                        </div>
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
    @endif

    @if (! isset($editServerGroup))
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
                    action="/servers/{{ $editServer->id }}"
                    @else
                    action="/servers"
                    @endif
                >
                    {{ csrf_field() }}
                    @foreach ($serverInputs as $input)
                        @include($input['view'])
                    @endforeach
                    <div class="form-group">
                        <label for="server_group_id">Server Group</label>
                        <select name="server_group_id" id="server_group_id" class="form-control">
                            <option value="">Un-grouped</option>
                            @foreach ($serverGroups as $serverGroup)
                                <option
                                    value="{{ $serverGroup->id }}"
                                    @if (isset($editServer) && $editServer->server_group_id == $serverGroup->id)
                                    selected
                                    @endif
                                >
                                    {{ $serverGroup->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
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
    @endif

    @if (! isset($editServer))
        <div class="panel panel-default">
            <div class="panel-heading">
                @if (isset($editServerGroup))
                    Editing Server Group: {{ $editServerGroup->name }}
                @else
                    Add a Server Group
                @endif
            </div>
            <div class="panel-body">
                <form
                    method="POST"
                    @if (isset($editServerGroup))
                    action="/servers/edit-group/{{ $editServerGroup->id }}"
                    @else
                    action="/servers/add-group"
                    @endif
                >
                    {{ csrf_field() }}
                    @include('formPartials.text', [
                        'input' => [
                            'type' => 'text',
                            'name' => 'groupName',
                            'title' => 'Group Name',
                            'placeholder' => 'My Cool Group',
                            'value' => isset($editServerGroup) ? $editServerGroup->name : ''
                        ]
                    ])
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">
                            @if (isset($editServerGroup))
                                Save Server Group
                            @else
                                Add Server Group
                            @endif
                        </button>
                    </div>
                </form>
                {{--@if (isset($editServerGroup))
                    <br>
                    <form method="POST" action="/servers/delete-group/{{ $editServerGroup->id }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Delete Server Group</button>
                        </div>
                    </form>
                @endif--}}
            </div>
        </div>
    @endif

@endsection
