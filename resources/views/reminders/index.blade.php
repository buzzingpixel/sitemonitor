<?php

/** @var \Illuminate\Database\Eloquent\Collection $reminders */
/** @var array $postErrors */
/** @var array $postValues */

$timezone = new \Camroncade\Timezone\Timezone;

$pageTitle = 'Reminders';
if (isset($editReminder)) {
    $pageTitle = "Editing {$editReminder->name}";
}

?>

@extends('layouts.app')

@section('content')
    <div class="container">

        {{-- Breadcrumb if needed --}}
        @if (isset($editReminder))
            <ol class="breadcrumb u-background-white">
                <li><a href="/reminders">Reminders</a></li>
                <li class="active">Editing Reminder: {{ $editReminder->name }}</li>
            </ol>
        @endif

        {{-- List Reminders --}}
        @if ($reminders->count())
            <div class="panel panel-default">
                <div class="panel-heading">Reminders</div>
                <div class="panel-body u-overflow-scroll js-filter-table">
                    <input type="text" class="form-control js-filter-table__input" placeholder="Filter">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Start Reminding On</th>
                                <th>Last Reminder Sent On</th>
                                <th></th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reminders as $reminder)
                                <?php /** @var \App\Reminder $reminder */ ?>
                                <tr class=" @if ($reminder->start_reminding_on->getTimestamp() < time()) warning @endif js-filter-table__row">
                                    <td>{{ $reminder->name }}</td>
                                    <td>{{ $reminder->start_reminding_on->format('Y-m-d') }}</td>
                                    <td>
                                        @if ($reminder->last_reminder_sent)
                                            {{ $timezone->convertFromUTC($reminder->last_reminder_sent, Auth::user()->timezone, 'Y-m-d g:i:s a') }}
                                        @endif
                                    </td>
                                    <td><a class="btn btn-default" href="/reminders/edit/{{ $reminder->id }}">Edit</a></td>
                                    <td><a class="btn btn-default" href="/reminders/mark-complete/{{ $reminder->id }}">Mark Complete</a></td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif

        {{-- Add/edit reminder --}}
        <div class="panel panel-default">
            <div class="panel-heading">
                @if (isset($editReminder))
                    Editing Reminder: {{ $editReminder->name }}
                @else
                    Add Reminder
                @endif
            </div>
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
                        <textarea name="body" id="body" rows="4" class="form-control">@if (isset($postValues['body'])){{ $postValues['body'] }}@endif </textarea>
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
                        <button type="submit" class="btn btn-primary">
                            @if (isset($editReminder))
                                Edit Reminder
                            @else
                                Add Reminder
                            @endif
                        </button>
                    </div>
                </form>
                @if (isset($editReminder))
                    <br>
                    <form method="POST" action="/reminders/delete/{{ $editReminder->id }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Delete Reminder</button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
@endsection
