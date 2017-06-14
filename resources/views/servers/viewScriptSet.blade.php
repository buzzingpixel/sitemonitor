<?php

/** @var \App\ScriptSet $scriptSet */

$pageTitle = "Script Set: {$scriptSet->name}";

?>

@extends('servers.layout')

@section('serverContent')

    <ol class="breadcrumb u-background-white">
        <li><a href="/servers/scripts">Scripts</a></li>
        <li class="active">Editing Script Set: {{ $scriptSet->name }}</li>
    </ol>

    <form
        method="POST"
        action="/servers/scripts/{{ $scriptSet->id }}"
    >

        {{ csrf_field() }}

        <div class="panel panel-default">
            <div class="panel-heading">Script Set Name</div>
            <div class="panel-body">
                @include('formPartials.text', [
                    'input' => [
                        'type' => 'text',
                        'name' => 'setName',
                        'title' => 'Set Name',
                        'placeholder' => 'My Cool Set',
                        'value' => $scriptSet->name
                    ]
                ])
            </div>
        </div>

        <div class="form-group">
            <a class="btn btn-success">Add Script</a>
        </div>

        <br>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Script Set</button>
        </div>

    </form>

@endsection