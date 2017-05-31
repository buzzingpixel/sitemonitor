<?php

/** @var \Illuminate\Database\Eloquent\Collection $servers */
/** @var array $serverInputs */

?>

@extends('servers.layout')

@section('serverContent')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                @if ($servers->count())
                    <div class="panel panel-default">
                        <div class="panel-heading">Servers</div>
                        <div class="panel-body">
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
                                    @foreach ($servers as $server)
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

            </div>
        </div>
    </div>
@endsection
