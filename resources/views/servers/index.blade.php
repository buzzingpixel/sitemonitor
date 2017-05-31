<?php

/** @var \Illuminate\Database\Eloquent\Collection $servers */
/** @var array $serverInputs */

?>

@extends('layouts.app')

@section('content')
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
                    <div class="panel-heading">Add a Server</div>
                    <div class="panel-body">
                        <form method="POST" action="/servers">
                            {{ csrf_field() }}
                            @foreach ($serverInputs as $input)
                                @include($input['view'])
                            @endforeach
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Server</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
