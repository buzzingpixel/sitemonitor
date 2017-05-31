@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="panel panel-default">
                    <div class="panel-heading">Add a Server</div>

                    <div class="panel-body">
                        <form method="POST" action="/servers">
                            {{ csrf_field() }}
                            <div class="form-group @if (isset($postErrors['name'])) has-error @endif">
                                <label for="name">Name</label>
                                <input
                                    type="text"
                                    name="name"
                                    id="name"
                                    class="form-control"
                                    placeholder="my-server-name"
                                    @if (isset($postValues['name']))
                                    value="{{ $postValues['name'] }}"
                                    @endif
                                >
                                @if (isset($postErrors['name']))
                                    <span class="error text-danger">{{ $postErrors['name'] }}</span>
                                @endif
                            </div>
                            <div class="form-group @if (isset($postErrors['address'])) has-error @endif">
                                <label for="address">Address or IP</label>
                                <input
                                    type="text"
                                    name="address"
                                    id="address"
                                    class="form-control"
                                    placeholder="192.168.0.0.1"
                                    @if (isset($postValues['address']))
                                    value="{{ $postValues['address'] }}"
                                    @endif
                                >
                                @if (isset($postErrors['address']))
                                    <span class="error text-danger">{{ $postErrors['address'] }}</span>
                                @endif
                            </div>
                            <div class="form-group @if (isset($postErrors['port'])) has-error @endif">
                                <label for="port">SSH Port</label>
                                <input
                                    type="text"
                                    name="port"
                                    id="port"
                                    class="form-control"
                                    placeholder="22"
                                    @if (isset($postValues['port']))
                                    value="{{ $postValues['port'] }}"
                                    @else
                                    value="22"
                                    @endif
                                >
                                @if (isset($postErrors['port']))
                                    <span class="error text-danger">{{ $postErrors['port'] }}</span>
                                @endif
                            </div>
                            <div class="form-group @if (isset($postErrors['ssh_username'])) has-error @endif">
                                <label for="ssh_username">SSH User Name</label>
                                <input
                                    type="text"
                                    name="ssh_username"
                                    id="ssh_username"
                                    class="form-control"
                                    placeholder="forge"
                                    @if (isset($postValues['ssh_username']))
                                    value="{{ $postValues['ssh_username'] }}"
                                    @endif
                                >
                                @if (isset($postErrors['ssh_username']))
                                    <span class="error text-danger">{{ $postErrors['ssh_username'] }}</span>
                                @endif
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary">Add Server</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
