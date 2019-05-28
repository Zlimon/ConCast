@extends('layouts.layout')

@section('title')
    | Your channels
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <span><a href="/">Home</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/profile">Profile</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/profile">{{ Auth::user()->name }}</a> <i class="fas fa-long-arrow-alt-right"></i> Your channels</span>
                <span class="float-right"><a href="/profile/edit"><i class="fas fa-edit"></i> Edit profile</a></span>
            </div>

            <div class="card-body">
                <p class="float-right"><a href="/channel/create">Create new channel <i class="fas fa-plus"></i></a></p>

                <h2>Your channels</h2>
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
        </div>
    </div>
@endsection