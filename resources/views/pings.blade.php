@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Add Ping</div>

                    <div class="panel-body">
                        <form method="POST" action="/pings">

                            {{ csrf_field() }}

                            <div class="form-group @if (isset($postErrors['name'])) has-error @endif">
                                <label for="name">Name</label>
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
                                <label for="expect_every">Expect Every&hellip; (in minutes)</label>
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
                                <label for="warn_after">Warn After&hellip; (in minutes)</label>
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
                                <button type="submit" class="btn btn-primary">Add Ping</button>
                            </div>

                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection