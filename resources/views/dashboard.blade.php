@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
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
                                    <th>Edit</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($monitoredSites as $monitoredSite)
                                    <tr class="@if ($monitoredSite->hasError) danger @else success @endif">
                                        <td>{{ $monitoredSite->name }}</td>
                                        <td>{{ $monitoredSite->urls }}</td>
                                        <td>@if ($monitoredSite->hasError) Down @else Up @endif</td>
                                        <td><a href="/dashboard/site/{{ $monitoredSite->id }}">Edit</a></td>
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
                    <form method="POST" action="/dashboard">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Site Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="My Cool Site">
                        </div>
                        <div class="form-group">
                            <label for="urls">Site URLs to check</label>
                            <input type="text" name="urls" id="urls" class="form-control" placeholder="https://site1.com, https://site2.com">
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
