<?php

/** @var array $postErrors */
/** @var array $postValues */

$pageTitle = 'Reminders'

?>

@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Add/edit reminder --}}
        <div class="panel panel-default">
            <div class="panel-heading">Add Reminder</div>
            <div class="panel-body">
                <form method="POST">
                    {{ csrf_field() }}

                    {{-- Reminder Name --}}
                    <div class="form-group @if (isset($postErrors['name'])) has-error @endif">
                        <label for="name">Reminder Name</label>
                        <input type="text" name="name" id="name" class="form-control" placeholder="My Reminder" @if (isset($postValues['name'])) value="{{ $postValues['name'] }}" @endif >
                        @if (isset($postErrors['name'])) <span class="error text-danger">{{ $postErrors['name'] }}</span> @endif
                    </div>

                    {{-- Reminder Body --}}
                    <div class="form-group @if (isset($postErrors['body'])) has-error @endif">
                        <label for="body">Reminder Body</label>
                        <textarea name="body" id="body" rows="4" class="form-control"> @if (isset($postValues['body'])) value="{{ $postValues['body'] }}" @endif </textarea>
                        @if (isset($postErrors['body'])) <span class="error text-danger">{{ $postErrors['body'] }}</span> @endif
                    </div>

                    {{-- Start Reminding On --}}
                    <div class="form-group @if (isset($postErrors['name'])) has-error @endif">
                        <label for="start_reminding_on">Start Reminding On</label>
                        <input type="text" name="start_reminding_on" id="start_reminding_on" class="form-control" placeholder="2016-01-01" @if (isset($postValues['start_reminding_on'])) value="{{ $postValues['start_reminding_on'] }}" @endif >
                        @if (isset($postErrors['start_reminding_on'])) <span class="error text-danger">{{ $postErrors['start_reminding_on'] }}</span> @endif
                    </div>

                    {{-- Submit the form --}}
                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Add Reminder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
