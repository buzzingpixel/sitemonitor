@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <a href="/dashboard">&laquo; Back to dashboard</a><br><br>

            <div class="panel panel-default">
                <div class="panel-heading">Add monitored Site</div>

                <div class="panel-body">
                    <form method="POST" action="/dashboard/site/{{ $monitoredSite->id }}">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="name">Site Name</label>
                            <input type="text" name="name" id="name" class="form-control" placeholder="My Cool Site" value="{{ $monitoredSite->name }}">
                        </div>
                        <div class="form-group">
                            <label for="urls">Site URLs to check</label>
                            <input type="text" name="urls" id="urls" class="form-control" placeholder="https://site1.com, https://site2.com" value="{{ $monitoredSite->urls }}">
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
