<?php

/** @var \Illuminate\Database\Eloquent\Collection $servers */

?>

@extends('servers.layout')

@section('serverContent')
    @if ($servers->count())
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
    @endif
@endsection
