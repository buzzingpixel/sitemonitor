<?php

$nav = [
    [
        'title' => 'Index',
        'segment' => null,
    ],
    [
        'title' => 'User/Server Keys',
        'segment' => 'user-server-keys'
    ]
];

?>

@extends('layouts.app')

@section('content')

    <div class="container" style="margin-bottom: 30px;">
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs">
                    @foreach ($nav as $item)
                        <li
                            @if ($item['segment'] === Request::segment(2))
                            class="active"
                            @endif
                        >
                            <a
                                @if ($item['segment'])
                                href="/servers/{{ $item['segment'] }}"
                                @else
                                href="/servers"
                                @endif
                            >
                                {{ $item['title'] }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>

    @yield('serverContent')
@endsection
