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
                                    <tr class="@if ($monitoredSite->has_error) danger @else success @endif">
                                        <td>{{ $monitoredSite->name }}</td>
                                        <td>{{ $monitoredSite->urls }}</td>
                                        <td>@if ($monitoredSite->has_error) Down @else Up @endif</td>
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

            <div class="panel panel-default">
                <div class="panel-heading">Notification Emails</div>

                    <div class="panel-body">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>Email Address</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                                @foreach ($notificationEmails as $notificationEmail)
                                    <tr>
                                        <td>{{ $notificationEmail->email }}</td>
                                        <td><a href="/dashboard/email/{{ $notificationEmail->id }}">Delete</a></td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <td colspan="2">
                                        <form method="POST" action="/dashboard/email">
                                            {{ csrf_field() }}
                                            <div class="form-group">
                                                <label for="email">Add Email Address</label>
                                                <input type="text" name="email" id="email" class="form-control" placeholder="name@site.com">
                                            </div>
                                            <div class="form-group">
                                                <button type="submit" class="btn btn-primary">Add Email Address</button>
                                            </div>
                                        </form>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

            </div>

        </div>
    </div>
</div>
@endsection
