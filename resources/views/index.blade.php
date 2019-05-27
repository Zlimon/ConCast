@extends('layouts.layout')

@section('title')
    | {{ __('title.welcome') }}
@endsection

@section('content')
    <div class="container">
        <h1 class="modal-header">Popular podcasts</h1>

        <div class="row">
            @foreach ($popularPodcasts as $podcast)
                <div class="col mb-4">
                    <div class="card bg-dark text-white">
                        <img class="card-img img-fluid" style="height: 250px;" src="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}" alt="Card image" />
                        <div class="card-img-overlay">
                            <h2 class="card-text bg-dark" style="background: rgba(122, 130, 136, 0.5)!important;">{{ $podcast->podcast_title }}</h2>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row">
            <div class="col-md-8 mb-4">
                @auth
                    <h2 class="modal-header">Suggested podcasts for you</h2>

                    <div class="row">
                        @foreach ($suggestedPodcasts as $podcast)
                            <div class="col mb-4">
                                <div class="card bg-dark text-white">
                                    <img class="card-img img-fluid" style="height: 150px;" src="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}" alt="Card image" />
                                    <div class="card-img-overlay">
                                        <h4 class="card-text bg-dark" style="background: rgba(122, 130, 136, 0.5)!important;">{{ $podcast->podcast_title }}</h4>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endauth

                <h2 class="modal-header">Popular channels</h2>

                <div class="card-deck">
                    @foreach ($popularChannels as $channel)
                        <div class="col-sm-4">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title"><a href="/channel/{{ $channel->id }}">{{ $channel->channel_name }}</a></h5>
                                    <p class="card-text">{{ $channel->channel_bio }}</p>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="col-sm-4">
                <div class="card">
                    <div class="card-header bg-dark text-light">
                        Recent podcasts
                    </div>
                    @foreach ($recentPodcasts as $podcast)
                        <div class="p-3 border-bottom">
                            <a href="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}">
                                <img class="mr-3 float-left bg-dark rounded" src="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $podcast->podcast_title }}" width="100px" height="100px" />
                                <span><b>{{ $podcast->podcast_title }}</b></span>
                            </a>
                            <br>
                            <span>
                                {{ Helper::calculatePostTime($podcast->created_at) }}
                                |
                                {{ Helper::calculateAudioLength($podcast->audio->audio_file_length) }}
                            </span>
                            <br>
                            <span>Uploaded by: <b><a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a></b></span>
                        </div>
                    @endforeach

                    <a href="/discover" class="btn btn-info" role="button">Discover more</a>
                </div>
            </div>
        </div>
    </div>
@endsection