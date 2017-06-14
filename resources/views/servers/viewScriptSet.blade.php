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
        class="js-edit-script-set"
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

        <div class="js-scripts-container">
            @foreach ($scriptSet->scripts as $script)
                <?php /** @var \App\Script $script */ ?>
                @include('servers.partials.script', [
                    'scriptId' => $script->id,
                    'scriptName' => $script->name,
                    'scriptContent' => $script->content,
                ])
            @endforeach
        </div>

        <div class="form-group">
            <a class="btn btn-success js-add-script">Add Script</a>
        </div>

        <br>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Script Set</button>
        </div>

    </form>

@endsection
