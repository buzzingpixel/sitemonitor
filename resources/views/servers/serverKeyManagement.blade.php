<?php

/** @var \Illuminate\Database\Eloquent\Collection $servers */

?>

@extends('servers.layout')

@section('serverContent')
    @if ($servers->count())

        {{-- List servers to list authorized key on a server --}}
        <div class="panel panel-default">
            <div class="panel-heading">Servers</div>
            <div class="panel-body">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($servers as $server)
                            <?php /** @var \App\Server $server */ ?>
                            <tr>
                                <td>{{ $server->name }}</td>
                                <td><a href="/servers/server-key-management/list-authorized-keys/{{ $server->id }}">List Authorized Keys</a></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
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
                    <div class="form-group">
                        <label>Servers</label><br>
                        <label>
                            <input type="checkbox" name="allServers" value="1"> All servers
                        </label>
                        @foreach ($servers as $server)
                            <?php /** @var \App\Server $server */ ?>
                            <br>
                            <label style="font-weight: normal;">
                                <input type="checkbox" name="servers[]" value="{{ $server->id }}"> {{ $server->name }}
                            </label>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Key</button>
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
                    <div class="form-group">
                        <label>Servers</label><br>
                        <label>
                            <input type="checkbox" name="allServers" value="1"> All servers
                        </label>
                        @foreach ($servers as $server)
                            <?php /** @var \App\Server $server */ ?>
                            <br>
                            <label style="font-weight: normal;">
                                <input type="checkbox" name="servers[]" value="{{ $server->id }}"> {{ $server->name }}
                            </label>
                        @endforeach
                    </div>
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Remove Key</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
@endsection
