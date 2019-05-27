@extends('layouts.layout')

@section('title')
    | {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <span><a href="/">Home</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/profile">Profile</a> <i class="fas fa-long-arrow-alt-right"></i> {{ Auth::user()->name }}</span>
                <span class="float-right"><a href="/profile/edit"><i class="fas fa-edit"></i> Edit profile</a></span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-9">
                        <h1>Welcome back, {{ Auth::user()->name }}</h1>
                    </div>

                    <div class="col-3 text-right">
                        <p style="display: inline;">{{ Auth::user()->name }}<i style="font-size: 2em; vertical-align: middle;" class="fas fa-user ml-1"></i></p>
                        <br>
                        <p style="display: inline;">{{ Auth::user()->email }}<i style="font-size: 2em; vertical-align: middle;" class="fas fa-envelope-square ml-1"></i></p>
                        <br>
                        <p style="display: inline;"><a href="/channel/create">Create channel</a><i style="font-size: 2em; vertical-align: middle;" class="fas fa-plus ml-1"></i></p>
                        <br>
                    </div>
                </div>

                <div class="row">
                    <div class="col-6">
                        <h2>Your top channels</h2>
                        <ul>
                            @foreach ($channels as $channel)
                                <li><a href="/channel/{{ $channel->id }}">{{ $channel->channel_name }}</a> <a href="/channel/{{ $channel->id }}/edit"><i class="fas fa-edit"></i></a></li>

                                <ul>
                                    @foreach ($channel->podcasts as $podcast)
                                        <li><a href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}">{{ $podcast->podcast_title }}</a> <a href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}/edit"><i class="fas fa-edit"></i></a></li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>
                    </div>

                    <div class="col-6">
                        <h2>Your top podcasts</h2>
                        <ul>
                            @foreach ($channel->podcasts as $podcast)
                                <li><a href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}">{{ $podcast->podcast_title }}</a> <a href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}/edit"><i class="fas fa-edit"></i></a></li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection