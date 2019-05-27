@extends('layouts.layout')

@section('title')
    | {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/profile">{{ __('title.profile') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/profile">{{ Auth::user()->name }}</a> <i class="fas fa-long-arrow-alt-right"></i> Podcasts</span>
                <span class="float-right"><a href="/profile/edit"><i class="fas fa-edit"></i> Edit profile</a></span>
            </div>

            <div class="card-body">
                <p class="float-right"><a href="/upload">Upload podcast</a></p>

                <h2>Your podcasts</h2>
                <ul>
                    @foreach ($channels as $channel)
                        @foreach ($channel->podcasts as $podcast)
                            <li><a href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}">{{ $podcast->podcast_title }}</a> <a href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}/edit"><i class="fas fa-edit"></i></a></li>
                        @endforeach
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endsection