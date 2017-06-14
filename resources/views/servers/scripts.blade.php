<?php

$pageTitle = 'Scripts';

?>

@extends('servers.layout')

@section('serverContent')

    <div class="panel panel-default">
        <div class="panel-heading">Add Script Set</div>
        <div class="panel-body">
            <form
                method="POST"
                action="/servers/scripts/add-script-set"
            >
                {{ csrf_field() }}
                @include('formPartials.text', [
                    'input' => [
                        'type' => 'text',
                        'name' => 'setName',
                        'title' => 'Set Name',
                        'placeholder' => 'My Cool Set',
                    ]
                ])
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Script Set</button>
                </div>
            </form>
        </div>
    </div>

@endsection
