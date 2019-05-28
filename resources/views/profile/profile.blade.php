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
                    <div class="col-md-8">
                        <h1>Welcome back, {{ Auth::user()->name }}</h1>
                    </div>

                    <div class="col-md-4 text-right">
                        <ul style="list-style: none;">
                            <li>{{ Auth::user()->name }} <i style="font-size: 2em; vertical-align: middle;" class="fas fa-user ml-1"></i></li>
                            <li>{{ Auth::user()->email }} <i style="font-size: 2em; vertical-align: middle;" class="fas fa-envelope-square ml-1"></i></li>
                            <li><a href="/channel/create">Create channel <i style="font-size: 2em; vertical-align: middle;" class="fas fa-plus ml-1"></i></a></li>
                            <li><a href="/upload">Upload podcast <i style="font-size: 2em; vertical-align: middle;" class="fas fa-upload"></i></a></li>
                        </ul>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <h2>Your channels</h2>
                        @foreach ($channels as $channel)
                            <a href="/channel/{{ $channel->id }}">
                                <img class="rounded-circle p-1" style="width: 150px;" src="{{ url('/storage/image')}}/{{ $channel->image->image_file_name }}.{{ $channel->image->image_file_extension }}" alt="Channel image" title="{{ $channel->channel_name }}">
                            </a>
                        @endforeach
                    </div>

                    <div class="col-md-6">
                        <h2>Your channel podcasts</h2>
                        <ul>
                            @foreach ($channels as $channel)
                                <li class="bg-light">
                                    <a href="/channel/{{ $channel->id }}">
                                        <img class="rounded-left mr-2" style="width: 50px; margin-left: -35px;" src="{{ url('/storage/image')}}/{{ $channel->image->image_file_name }}.{{ $channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $channel->channel_name }}">{{ $channel->channel_name }}
                                    </a>
                                    <a href="/channel/{{ $channel->id }}/edit"><i class="fas fa-edit"></i></a>
                                </li>

                                <ul style="margin-bottom: 25px;">
                                    @foreach ($channel->podcasts as $podcast)
                                        <li>
                                            <a href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}">{{ $podcast->podcast_title }}</a>
                                            <a href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}/edit"><i class="fas fa-edit"></i></a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection