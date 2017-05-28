<?php

/** @var \App\MonitoredSite $monitoredSite */
/** @var array $postErrors */
/** @var array $postValues */

?>

@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="/dashboard">&laquo; Back to dashboard</a><br><br>

            <div class="panel panel-default">
                <div class="panel-heading">Add monitored Site</div>

                <div class="panel-body">
                    <form method="POST" action="/sites/edit/{{ $monitoredSite->id }}">
                        {{ csrf_field() }}
                        <div class="form-group @if (isset($postErrors['name'])) has-error @endif">
                            <label for="name">Site Name</label>
                            <input
                                type="text"
                                name="name"
                                id="name"
                                class="form-control"
                                placeholder="My Cool Site"
                                @if (isset($postValues['name']))
                                value="{{ $postValues['name'] }}"
                                @else
                                value="{{ $monitoredSite->name }}"
                                @endif
                            >
                            @if (isset($postErrors['name']))
                                <span class="error text-danger">{{ $postErrors['name'] }}</span>
                            @endif
                        </div>
                        <div class="form-group @if (isset($postErrors['urls'])) has-error @endif">
                            <label for="urls">Site URLs to check</label>
                            <input
                                type="text"
                                name="urls"
                                id="urls"
                                class="form-control"
                                placeholder="https://site1.com, https://site2.com"
                                @if (isset($postValues['urls']))
                                value="{{ $postValues['urls'] }}"
                                @else
                                value="{{ $monitoredSite->urls }}"
                                @endif
                            >
                            @if (isset($postErrors['urls']))
                                <span class="error text-danger">{{ $postErrors['urls'] }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Update Site</button>
                        </div>
                    </form>
                    <br>
                    <form method="POST" action="/dashboard/site/delete/{{ $monitoredSite->id }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <button type="submit" class="btn btn-danger">Delete Site</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
