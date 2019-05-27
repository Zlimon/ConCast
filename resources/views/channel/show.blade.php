@extends('layouts.layout')

@section('title')
    | {{ $channel->channel_name }}
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">{{ __('title.channel') }}</a> <i class="fas fa-long-arrow-alt-right"></i> {{ $channel->channel_name }}</span>
                <span class="float-right"><a href="/channel/{{ $channel->id }}/edit"><i class="fas fa-edit"></i> Edit {{ $channel->channel_name }}</a></span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-8">
                        <h1 class="input-group">
                            {{ $channel->channel_name }}

                            <div class="ml-2">
                                @guest
                                    <p><a class="btn btn-primary" href="/login">Log in to subsribe to this channel</a></p>
                                @else
                                    @if (Helper::getUserSubscriber())
                                        <form method="POST" action="/channel/{{ $channel->id }}/unsubscribe">
                                            @method('DELETE')
                                            @csrf

                                            <button class="btn btn-danger"><i class="fas fa-minus"></i> Unsubscribe</button>
                                        </form>
                                    @else
                                        <form method="POST" action="/channel/{{ $channel->id }}/subscribe">
                                            @csrf

                                            <button class="btn btn-success"><i class="fas fa-plus"></i> Subscribe</button>
                                        </form>
                                    @endif
                                @endguest
                            </div>
                        </h1>
                        @if ($channel->channel_bio)
                            <p><b>{{ $channel->channel_bio }}</b></p>
                        @else
                            <p><i>No channel bio</i></p>
                        @endif

                        <p>{{ number_format($channel->subscriptions->count()) }} subscribers</p>
                    </div>

                    <div class="col-4 text-right">
                        <p style="display: inline;">{{ $channel->channel_email }}<i style="font-size: 2em; vertical-align: middle;" class="fas fa-envelope-square ml-1"></i></p>
                        <br>
                        <p style="display: inline;"><a target="_blank" rel="noopener noreferrer" href="{{ $channel->channel_facebook }}">{{ ($channel->channel_facebook ? 'Facebook' : 'None') }}</a><i style="font-size: 2em; vertical-align: middle;" class="fab fa-facebook-square ml-1"></i></p>
                        <br>
                        <p style="display: inline;"><a target="_blank" rel="noopener noreferrer" href="{{ $channel->channel_twitter }}">{{ ($channel->channel_twitter ? 'Twitter' : 'None') }}</a><i style="font-size: 2em; vertical-align: middle;" class="fab fa-twitter-square ml-1"></i></p>
                        <br>
                        <p>
                            Created {{ \Carbon\Carbon::parse($channel->created_at)->format('d. M Y') }}
                            <br>
                            @if ($latestUpload)
                                Latest upload: {{ Helper::calculatePostTime($latestUpload->created_at) }}
                            @endif
                        </p>
                    </div>
                </div>

                @if ($channel->podcasts->count())
                    <h2>Podcasts</h2>

                    <section class="audio-player card mt-3">
                        <div class="card bg-dark">
                            <div class="card-body">
                                <h2 class="card-title col text-center text-light">{{ $channel->channel_name }} album</h2>
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
                                        class="active list-group-item playlist-item"><a style="color: black;" href="{{ url('/storage', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}" download>Download {{ $podcast->podcast_title }}</a> - <a style="color: black;" href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}">Visit podcast</a></li>

                                        @continue
                                    @endif
                                    <li audio_url="{{ url('/storage', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}"
                                    img_url="{{ url('/storage')}}/{{ $podcast->image->image_file_name }}.{{ $podcast->image->image_file_extension }}"
                                    class="list-group-item playlist-item"><a style="color: black;" href="{{ url('/storage', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}" download>Download {{ $podcast->podcast_title }}</a> - <a style="color: black;" href="/channel/{{ $channel->id }}/podcast/{{ $podcast->id }}">Visit podcast</a></li>
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

    <script src="{{ asset('js/jquery-ui-slider.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/audioPlayer.js') }}" charset="utf-8"></script>
@endsection