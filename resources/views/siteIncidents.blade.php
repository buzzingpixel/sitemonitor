<?php

/** @var \App\MonitoredSite $monitoredSite */
$timezone = new \Camroncade\Timezone\Timezone;

?>

@extends('layouts.app', [
    'pageTitle' => "{$monitoredSite->name} Incidents"
])

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <ol class="breadcrumb u-background-white">
                <li><a href="/sites">Sites</a></li>
                <li class="active">Incidents for &ldquo;{{ $monitoredSite->name }}&rdquo;</li>
            </ol>

            <div class="panel panel-default">
                <div class="panel-heading">Last 50 incidents for &ldquo;{{ $monitoredSite->name }}&rdquo;</div>

                <div class="panel-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="width: 20%;">Type</th>
                                <th style="width: 20%;">Date</th>
                                <th style="width: 15%;">Code</th>
                                <th style="width: 45%;">Message</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($monitoredSite->incidents as $incident)
                                <?php /** @var \App\SiteIncident $incident */ ?>

                                <tr class="@if ($incident->event_type === 'down') danger @else success @endif">
                                    <td>
                                        @if ($incident->event_type === 'down')
                                            {{ $monitoredSite->name }} went down
                                        @else
                                            {{ $monitoredSite->name }} came back up
                                        @endif
                                    </td>
                                    <td>
                                        {{ $timezone->convertFromUTC($incident->created_at, Auth::user()->timezone, 'Y-m-d g:i:s a') }}
                                    </td>
                                    <td>{{ $incident->status_code }}</td>
                                    <td>{{ $incident->message }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
