@extends('layouts.layout')

@section('title')
    | {{ __('title.channel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> {{ __('title.channel') }}</span>
                    </div>

                    <div class="card-body">
                        <h1>{{ __('title.channel') }}</h1>
                        @guest

                        @else
                            <p><a href="/channel/create">Create channel</a></p>

                            @foreach ($channels as $channel)
                                <p><a href="/channel/{{ $channel->id }}">{{ $channel->channel_name }}</a> <a href="/channel/{{ $channel->id }}/edit"><i class="fas fa-edit"></i></a></p>
                            @endforeach
                        @endguest
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection