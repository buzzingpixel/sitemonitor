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
                                    <tr class="@if ($monitoredSite->has_error) danger @else success @endif">
                                        <td>{{ $monitoredSite->name }}</td>
                                        <td>{!! implode('<br>', $monitoredSite->getUrlsAsArray()) !!}</td>
                                        <td>@if ($monitoredSite->has_error) Down @else Up @endif</td>
                                        <td>{{ $monitoredSite->last_checked }}</td>
                                        <td><a href="/dashboard/site/incidents/{{ $monitoredSite->id }}">View</a></td>
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

            @if ($users->count())
                <form method="POST" action="/dashboard/users">
                    {{ csrf_field() }}
                    <div class="panel panel-default">
                        <div class="panel-heading">User Privileges</div>

                            <div class="panel-body">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>Name</th>
                                        <th>Login Email</th>
                                        <th>Has Access</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($users as $user)
                                            <tr>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>
                                                    <input type="hidden" name="users[{{ $user->id }}][is_admin]" value="0">
                                                    <input
                                                        type="checkbox"
                                                        name="users[{{ $user->id }}][is_admin]"
                                                        value="1"
                                                        @if ($user->is_admin)
                                                            checked
                                                        @endif
                                                    >
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">Update User Privileges</button>
                                </div>
                            </div>
                    </div>
                </form>
            @endif

        </div>
    </div>
</div>
@endsection
