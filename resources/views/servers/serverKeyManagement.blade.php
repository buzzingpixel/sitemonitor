<?php

/** @var \Illuminate\Database\Eloquent\Collection $serverGroups */
/** @var \Illuminate\Database\Eloquent\Collection $unGroupedServers */

$serverSelectPaddingCount = $serverGroups->count() + $unGroupedServers->count();
if ($unGroupedServers->count()) {
    $serverSelectPaddingCount ++;
}
foreach ($serverGroups as $serverGroup) {
    /** @var \App\Server $server */
    $serverSelectPaddingCount += $serverGroup->servers->count();
}
$serverSelectPadding = number_format(($serverSelectPaddingCount * 18.5));

?>

@extends('servers.layout', [
    'pageTitle' => 'Server Key Management'
])

@section('serverContent')

    @if ($serverGroups->count() || $unGroupedServers->count())

        <div class="js-filter-table">

            <input type="text" class="form-control js-filter-table__input" placeholder="Filter"><br>

            {{-- List servers to list authorized key on a server --}}
            @foreach ($serverGroups as $serverGroup)
                @if ($serverGroup->servers->count())
                    <?php /** @var \App\ServerGroup $serverGroup */ ?>
                    <div class="panel panel-default js-filter-table__parent-hide-on-no-results">
                        <div class="panel-heading">{{ $serverGroup->name }}</div>
                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($serverGroup->servers as $server)
                                        <?php /** @var \App\Server $server */ ?>
                                        <tr class="js-filter-table__row">
                                            <td>{{ $server->name }}</td>
                                            <td>
                                                <a class="btn btn-default" href="/servers/server-key-management/list-authorized-keys/{{ $server->id }}">
                                                    List Authorized Keys
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif
            @endforeach

            @if ($unGroupedServers->count())
                <div class="panel panel-default js-filter-table__parent-hide-on-no-results">
                    <div class="panel-heading">Un-grouped</div>
                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($unGroupedServers as $server)
                                    <?php /** @var \App\Server $server */ ?>
                                    <tr class="js-filter-table__row">
                                        <td>{{ $server->name }}</td>
                                        <td><a href="/servers/server-key-management/list-authorized-keys/{{ $server->id }}">List Authorized Keys</a></td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

        </div>

        {{-- Add an SSH key to any or all servers --}}
        <div class="panel panel-default">
            <div class="panel-heading">Add SSH Key</div>
            <div class="panel-body">
                <form method="POST" action="/servers/server-key-management/add-authorized-key">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="key">Key</label>
                        <textarea name="key" id="key" rows="5" class="form-control" spellcheck="false"></textarea>
                    </div>
                    @include('formPartials.serverSelect')
                    <div class="form-group">
                        <button type="submit" class="btn btn-success">Add Key</button>
                    </div>
                </form>
            </div>
        </div>

        {{-- Remove an SSH key from any or all servers --}}
        <div class="panel panel-default">
            <div class="panel-heading">Remove SSH Key</div>
            <div class="panel-body">
                <form method="POST" action="/servers/server-key-management/remove-authorized-key">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label for="key">Key</label>
                        <textarea name="key" id="key" rows="5" class="form-control" spellcheck="false"></textarea>
                    </div>
                    @include('formPartials.serverSelect')
                    <div class="form-group">
                        <button type="submit" class="btn btn-danger">Remove Key</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

@endsection
