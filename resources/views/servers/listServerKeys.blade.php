<?php

/** @var \App\Server $server */
/** @var \BuzzingPixel\DataModel\ModelCollection $keys */

?>

@extends('servers.layout', [
    'pageTitle' => "Authorized Keys on {$server->name}"
])

@section('serverContent')
    <ol class="breadcrumb u-background-white">
        <li><a href="/servers/server-key-management">Server Key Management</a></li>
        <li class="active">Authorized Keys on {{ $server->name }}</li>
    </ol>
    <div class="panel panel-default">
        <div class="panel-heading">Authorized Keys on {{ $server->name }}</div>
        <div class="panel-body">

            @foreach ($keys as $key)
                <?php /** @var \App\DataModel\ServerAuthorizedKey $key */ ?>
                <div class="form-group">
                    <textarea rows="5" class="form-control" spellcheck="false">{{ $key->key }}</textarea>
                </div>
            @endforeach

        </div>
    </div>
@endsection
