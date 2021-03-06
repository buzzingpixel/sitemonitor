<?php

/** @var \Illuminate\Database\Eloquent\Collection $pings */
/** @var array $postErrors */
/** @var array $postValues */
$timezone = new \Camroncade\Timezone\Timezone;

$pageTitle = 'Pings';
if (isset($editPing)) {
    $pageTitle = "Editing {$editPing->name}";
}

?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @if (isset($editPing))
                    <ol class="breadcrumb u-background-white">
                        <li><a href="/pings">Pings</a></li>
                        <li class="active">Editing Ping: {{ $editPing->name }}</li>
                    </ol>
                @endif

                @if ($pings->count())
                    <div class="panel panel-default">
                        <div class="panel-heading">Pings</div>

                            <div class="panel-body u-overflow-scroll js-filter-table">
                                <input type="text" class="form-control js-filter-table__input" placeholder="Filter">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Expect Every</th>
                                        <th>Warn After</th>
                                        <th>Ping Url</th>
                                        <th>Last Ping</th>
                                        <th>Status</th>
                                        <th></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($pings as $ping)
                                            <?php /** @var \App\Ping $ping */ ?>

                                            <tr class="@if ($ping->getHealthStatus() === 'pastWarning') danger @elseif ($ping->getHealthStatus() === 'pastExpect') warning @else success @endif js-filter-table__row">
                                                <td>{{ $ping->name }}</td>
                                                <td>{{ $ping->getMinutes('expect_every') }} minutes</td>
                                                <td>{{ $ping->getMinutes('warn_after') }} minutes</td>
                                                <td>
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu{{ $ping->guid }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                                                            Show Ping URL
                                                            <span class="caret"></span>
                                                        </button>
                                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu{{ $ping->guid }}">
                                                            <li style="padding: 0 4px; min-width: 320px;">
                                                                <input
                                                                    type="text"
                                                                    value="{{ $ping->getPingUrl() }}"
                                                                    class="form-control"
                                                                >
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </td>
                                                <td>{{ $timezone->convertFromUTC($ping->asCarbon('last_ping'), Auth::user()->timezone, 'Y-m-d g:i:s a') }}</td>
                                                <td>
                                                    @if ($ping->getHealthStatus() === 'pastWarning')
                                                        Missing
                                                    @elseif ($ping->getHealthStatus() === 'pastExpect')
                                                        Overdue
                                                    @else
                                                        &#x1f44d;
                                                    @endif
                                                </td>
                                                <td>
                                                    <a class="btn btn-default" href="/pings/edit/{{ $ping->id }}">
                                                        Edit
                                                    </a>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br>
                            </div>

                    </div>
                @endif

                <div class="panel panel-default">
                    <div class="panel-heading">
                        @if (isset($editPing))
                            Editing Ping: {{ $editPing->name }}
                        @else
                            Add Ping
                        @endif
                    </div>

                    <div class="panel-body">
                        <form
                            method="POST"
                            @if (isset($editPing))
                            action="/pings/edit/{{ $editPing->id }}"
                            @else
                            action="/pings"
                            @endif
                        >

                            {{ csrf_field() }}

                            <div class="form-group @if (isset($postErrors['name'])) has-error @endif">
                                <label for="name">
                                    Ping Name<br>
                                    <span class="info text-info" style="font-weight: normal">
                                        Give this ping a name you will recognize
                                    </span>
                                </label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control"
                                    placeholder="My Ping"
                                    @if (isset($postValues['name']))
                                    value="{{ $postValues['name'] }}"
                                    @endif
                                >
                                @if (isset($postErrors['name']))
                                    <span class="error text-danger">{{ $postErrors['name'] }}</span>
                                @endif
                            </div>

                            <div class="form-group @if (isset($postErrors['expect_every'])) has-error @endif">
                                <label for="expect_every">
                                    Expect Every&hellip; (in minutes)<br>
                                    <span class="info text-info" style="font-weight: normal">
                                        Specify in minutes how often to expect this ping
                                    </span>
                                </label>
                                <input
                                    type="text"
                                    name="expect_every"
                                    id="expect_every"
                                    class="form-control"
                                    placeholder="10"
                                    @if (isset($postValues['expect_every']))
                                    value="{{ $postValues['expect_every'] }}"
                                    @endif
                                >
                                @if (isset($postErrors['expect_every']))
                                    <span class="error text-danger">{{ $postErrors['expect_every'] }}</span>
                                @endif
                            </div>

                            <div class="form-group @if (isset($postErrors['warn_after'])) has-error @endif">
                                <label for="warn_after">
                                    Warn After&hellip; (in minutes)<br>
                                    <span class="info text-info" style="font-weight: normal">
                                        Specify in minutes when to warn after not hearing from ping
                                    </span>
                                </label>
                                <input
                                    type="text"
                                    name="warn_after"
                                    id="warn_after"
                                    class="form-control"
                                    placeholder="10"
                                    @if (isset($postValues['warn_after']))
                                    value="{{ $postValues['warn_after'] }}"
                                    @endif
                                >
                                @if (isset($postErrors['warn_after']))
                                    <span class="error text-danger">{{ $postErrors['warn_after'] }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">
                                    @if (isset($editPing))
                                        Save Ping
                                    @else
                                        Add Ping
                                    @endif
                                </button>
                            </div>

                        </form>
                        @if (isset($editPing))
                            <br>
                            <form method="POST" action="/pings/delete/{{ $editPing->id }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <button type="submit" class="btn btn-danger">Delete Ping</button>
                                </div>
                            </form>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
