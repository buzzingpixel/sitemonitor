<?php

/** @var \Illuminate\Database\Eloquent\Collection $scriptSets */

$pageTitle = 'Scripts';

?>

@extends('servers.layout')

@section('serverContent')

    <div class="panel panel-default">
        <div class="panel-heading">Add Script Set</div>
        <div class="panel-body">
            <form
                method="POST"
                action="/servers/scripts/add-script-set"
            >
                {{ csrf_field() }}
                @include('formPartials.text', [
                    'input' => [
                        'type' => 'text',
                        'name' => 'setName',
                        'title' => 'Set Name',
                        'placeholder' => 'My Cool Set',
                    ]
                ])
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Add Script Set</button>
                </div>
            </form>
        </div>
    </div>

    @if ($scriptSets->count())
        <div class="panel panel-default">
            <div class="panel-heading">Script Sets</div>
            <div class="panel-body u-overflow-scroll">
                <table class="table table-striped">
                    <thead>
                    <tr>
                        <th>Name</th>
                        <th></th>
                        <th></th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($scriptSets as $scriptSet)
                        <?php /** @var \App\ScriptSet $scriptSet */ ?>
                        <tr>
                            <td>{{ $scriptSet->name }}</td>
                            <td>
                                <a class="btn btn-default" href="/servers/scripts/{{ $scriptSet->id }}">
                                    Edit Set
                                </a>
                            </td>
                            <td>
                                <a class="btn btn-default" href="/servers/scripts/run/{{ $scriptSet->id }}">
                                    Run Set&hellip;
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

@endsection
