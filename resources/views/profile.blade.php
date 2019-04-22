@extends('layouts.layout')

@section('title')
    | {{ Auth::user()->name }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/profile">{{ __('title.profile') }}</a> <i class="fas fa-long-arrow-alt-right"></i> {{ Auth::user()->name }}</span>
                    </div>

                    <div class="card-body">
                        <h1>{{ __('title.profile') }}</h1>

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
        </div>
    </div>
@endsection