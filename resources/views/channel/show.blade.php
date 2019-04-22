@extends('layouts.layout')

@section('title')
    | {{ $channel->channel_name }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">{{ __('title.channel') }}</a> <i class="fas fa-long-arrow-alt-right"></i> {{ $channel->channel_name }}</span>
                        <span class="float-right"><a href="/channel/{{ $channel->id }}/edit"><i class="fas fa-edit"></i> Edit {{ $channel->channel_name }}</a></span>
                    </div>

                    <div class="card-body">
                        <h1>{{ $channel->channel_name }}</h1>
                        @if (!empty($channel->channel_bio))
                            <p><b>{{ $channel->channel_bio }}</b></p>
                        @else
                            <p><i>No channel bio</i></p>
                        @endif

                        @if ($channel->podcasts->count())
                            <section class="audio-player card mt-3">
                                <div class="card bg-dark">
                                    <div class="card-body">
                                        <h2 class="card-title col text-center text-light">{{ $first[0]->podcast_title }}</h2>
                                        <div class="row align-items-center mt-4 mb-3 mx-0">
                                            <i id="play-button"class="material-icons play-pause text-primary mr-2" aria-hidden="true">play_circle_outline</i>
                                            <i id="pause-button"class="material-icons play-pause d-none text-primary mr-2" aria-hidden="true">pause_circle_outline</i>
                                            <i id="next-button"class="material-icons text-primary ml-2 mr-3" aria-hidden="true">skip_next</i>
                                            <div class="col ml-auto rounded-circle border border-primary p-1">
                                                <img id="thumbnail" class="img-fluid rounded-circle" src="{{ url('/storage')}}/{{ $first[0]->image->image_file_name }}.{{ $first[0]->image->image_file_extension }}" alt="">
                                            </div>
                                        </div>
                                        <div class="p-0 m-0 text-light" id="now-playing">
                                            <p class="font-italic mb-0">Now Playing: </p>
                                            <p class="lead" id="title"></p>
                                        </div>
                                        <div class="progress-bar progress col-12 mb-3"></div>
                                    </div>
                                    <ul class="playlist list-group list-group-flush">
                                        @foreach ($channel->podcasts as $podcast)
                                            @if ($loop->first)
                                                <li audio_url="{{ url('/storage', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}"
                                                img_url="{{ url('/storage')}}/{{ $podcast->image->image_file_name }}.{{ $podcast->image->image_file_extension }}"
                                                class="active list-group-item playlist-item">
                                                {{ $podcast->podcast_title }} - <a style="color: lightgray;" href="{{ url('/storage', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}" download>Download</a></li>

                                                @continue
                                            @endif
                                            <li audio_url="{{ url('/storage', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}"
                                            img_url="{{ url('/storage')}}/{{ $podcast->image->image_file_name }}.{{ $podcast->image->image_file_extension }}"
                                            class="list-group-item playlist-item">
                                            {{ $podcast->podcast_title }} - <a style="color: lightgray;" href="{{ url('/storage', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}" download>Download</a></li>
                                        @endforeach
                                    </ul>
                                    <!-- <div class="card-body">
                                        <a href="#" class="card-link">Card link</a>
                                        <a href="#" class="card-link">Another link</a>
                                    </div> !-->
                                </div>
                                <audio id="audio-player" class="d-none" src="" type="{{ url('/storage', $first[0]->audio->audio_file_name . '.' . $first[0]->audio->audio_file_extension) }}" controls="controls"></audio>
                            </section>
                        @else
                            <p class="text-center">This channel doesn't have any content</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-ui-slider.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/audioPlayer.js') }}" charset="utf-8"></script>
@endsection