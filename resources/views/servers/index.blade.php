<?php

/** @var array $serverInputs */

?>

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
                            @foreach ($serverInputs as $input)
                                @include($input['view'])
                            @endforeach
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
