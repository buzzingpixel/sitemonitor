<?php

/** @var \Illuminate\Database\Eloquent\Collection $monitoredSites */
/** @var array $postErrors */
/** @var array $postValues */

?>

@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Monitored Sites</div>

                    @if ($monitoredSites->count())

                        <div class="panel-body">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Site</th>
                                    <th>URLs to Check</th>
                                    <th>Status</th>
                                    <th>Last Checked</th>
                                    <th>Incidents</th>
                                    <th>Edit</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach ($monitoredSites as $monitoredSite)
                                        <?php /** @var \App\MonitoredSite $monitoredSite */ ?>

                                        <tr class="@if ($monitoredSite->has_error) danger @else success @endif">
                                            <td>{{ $monitoredSite->name }}</td>
                                            <td>
                                                @foreach ($monitoredSite->getUrlsAsArray() as $url)
                                                    <a href="{{ $url }}" target="_blank">{{ $url }}</a><br>
                                                @endforeach
                                            </td>
                                            <td>@if ($monitoredSite->has_error) Down @else &#x1f44d; @endif</td>
                                            <td>{{ $monitoredSite->last_checked }}</td>
                                            <td><a href="/sites/incidents/{{ $monitoredSite->id }}">View</a></td>
                                            <td><a href="/sites/edit/{{ $monitoredSite->id }}">Edit</a></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                    @endif
                </div>

                <div class="panel panel-default">
                    <div class="panel-heading">Add monitored Site</div>

                    <div class="panel-body">
                        <form method="POST" action="/sites">
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
                                    @endif
                                >
                                @if (isset($postErrors['urls']))
                                    <span class="error text-danger">{{ $postErrors['urls'] }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Site</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
