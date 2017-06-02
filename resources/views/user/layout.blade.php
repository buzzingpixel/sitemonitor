<?php

$nav = [
    [
        'title' => 'Settings',
        'segment' => null,
    ],
    [
        'title' => 'Change Password',
        'segment' => 'change-password'
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
                                href="/settings/{{ $item['segment'] }}"
                                @else
                                href="/settings"
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

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                @yield('innerContent')
            </div>
        </div>
    </div>
@endsection
