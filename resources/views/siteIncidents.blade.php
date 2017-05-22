@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <a href="/dashboard">&laquo; Back to dashboard</a><br><br>

            <div class="panel panel-default">
                <div class="panel-heading">Last 50 incidents for &ldquo;{{ $monitoredSite->name }}&rdquo;</div>

                <div class="panel-body">
                    <table class="table">
                        <tbody>
                            @foreach ($monitoredSite->incidents as $incident)
                                <tr class="@if ($incident->event_type === 'down') danger @else success @endif">
                                    <td>
                                        @if ($incident->event_type === 'down')
                                            {{ $monitoredSite->name }} went down
                                        @else
                                            {{ $monitoredSite->name }} came back up
                                        @endif
                                    </td>
                                    <td>
                                        {{ $incident->created_at }}
                                    </td>
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
