@extends('layouts.layout')

@section('title')
    | Listen to: "{{ $podcast->podcast_title }}"
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <span><a href="/">Home</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">Channel</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a> <i class="fas fa-long-arrow-alt-right"></i> Listen to: <b>{{ $podcast->podcast_title }}</b></span>
                <span class="float-right"><a href="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}/edit"><i class="fas fa-edit"></i> Edit {{ $podcast->podcast_title }}</a></span>
            </div>

            <div class="card-body">
                <div class="row">
                    <div class="col-3">
                        <img class="rounded" src="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $podcast->podcast_title }}" width="256px" height="256px" />
                        <h2 class="mt-2"><a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a></h2>
                        <h4>{{ number_format($podcast->channel->subscriptions->count()) }} subscribers</h4>
                        <p>Latest upload: {{ Helper::calculatePostTime($latestUpload->created_at) }}</p>

                        <div class="text-center">
                            @guest
                                <p><a href="/login">Log in to subsribe to this channel</a></p>
                            @else
                                @if (Helper::getUserSubscriber())
                                    <form method="POST" action="/channel/{{ $podcast->channel->id }}/unsubscribe">
                                        @method('DELETE')
                                        @csrf

                                        <button class="btn btn-danger btn-lg"><i class="fas fa-minus"></i> Unsubscribe</button>
                                    </form>
                                @else
                                    <form method="POST" action="/channel/{{ $podcast->channel->id }}/subscribe">
                                        @csrf

                                        <button class="btn btn-success btn-lg"><i class="fas fa-plus"></i> Subscribe</button>
                                    </form>
                                @endif
                            @endguest
                        </div>
                    </div>

                    <div class="col-9">
                        <h1>{{ $podcast->podcast_title }}</h1>
                        <p><small>{{ $timeAgo }} | {{ $audioLength }}</small></p>

                        <p>{{ $podcast->podcast_description }}</p>

                        <div class="form-inline">
                            @if (Auth::check())
                                <form method="POST" action="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}/rate">
                                    @csrf

                                    <div class="form-group">
                                        <span class="rating">
                                            <input type="radio" class="rating-input"
                                                   id="5" name="rating" value="5">
                                            <label for="5" class="rating-star"></label>
                                            <input type="radio" class="rating-input"
                                                   id="4" name="rating" value="4">
                                            <label for="4" class="rating-star"></label>
                                            <input type="radio" class="rating-input"
                                                   id="3" name="rating" value="3">
                                            <label for="3" class="rating-star"></label>
                                            <input type="radio" class="rating-input"
                                                   id="2" name="rating" value="2">
                                            <label for="2" class="rating-star"></label>
                                            <input type="radio" class="rating-input"
                                                   id="1" name="rating" value="1">
                                            <label for="1" class="rating-star"></label>
                                        </span>
                                    
                                        <button type="submit" class="btn btn-success btn-lg ml-3 mr-3">Rate</button>
                                    </div>
                                </form>
                            @endif

                            <button class="btn btn-dark btn-lg"><i class="fas fa-share"></i> Share this podcast</button>
                        </div>

                        <section class="audio-player card mt-3">
                            <div class="card bg-dark">
                                <div class="card-body">
                                    <h2 class="card-title col text-center text-light">{{ $podcast->podcast_title }}</h2>
                                    <div class="row align-items-center mt-4 mb-3 mx-0">
                                        <i id="play-button"class="material-icons play-pause text-primary mr-2" aria-hidden="true">play_circle_outline</i>
                                        <i id="pause-button"class="material-icons play-pause d-none text-primary mr-2" aria-hidden="true">pause_circle_outline</i>
                                        <i id="next-button"class="material-icons text-primary ml-2 mr-3" aria-hidden="true">skip_next</i>
                                        <div class="col ml-auto rounded-circle p-1">
                                            <img id="thumbnail" class="img-fluid rounded-circle" src="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}" alt="">
                                        </div>
                                    </div>
                                    <div class="p-0 m-0 text-light" id="now-playing">
                                        <p class="font-italic mb-0">Now Playing: </p>
                                        <p class="lead" id="title"></p>
                                    </div>
                                    <div class="progress-bar progress col-12 mb-3"></div>
                                </div>
                                <ul class="playlist list-group list-group-flush">
                                    <li audio_url="{{ url('/storage/audio', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}"
                                    img_url="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}"
                                    class="active list-group-item playlist-item">
                                    {{ $podcast->podcast_title }}</li>

                                </ul>
                                 <div class="card-body">
                                    <a class="btn btn-primary btn-lg" href="{{ url('/storage/audio', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}" download>Download {{ $podcast->podcast_title }}</a>
                                </div>
                            </div>
                            <audio id="audio-player" class="d-none" src="" type="{{ url('/storage/audio', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}" controls="controls"></audio>
                        </section>

                        <h1 class="modal-header">Comments</h1>
                        @guest
                            <p class="text-center"><a href="/login">Log in to comment on this podcast</a></p>
                        @else
                            <form method="POST" action="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}/comment">
                                @csrf

                                <div class="form-group">
                                    <textarea class="form-control" name="comment_text"></textarea>
                                </div>
                                <div class="form-group">
                                    <input type="submit" class="btn btn-success" value="Post comment" />
                                </div>
                            </form>
                        @endguest

                        @if($podcast->comment->count())
                            @foreach ($podcast->comment as $comment)
                                <div class="border-top p-3">
                                    <h5 class="text-primary"><b>{{ $comment->user->name }}</b></h5>
                                    <p>
                                        <span>{{ $comment->comment_text }}</span>
                                        <br>
                                        <span class="float-right text-info"><i class="fas fa-clock"></i> {{ Helper::calculatePostTime($comment->created_at) }}</span>
                                    </p>
                                </div>
                            @endforeach
                        @else
                            <p class="text-center">No comments</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/jquery-ui-slider.js') }}" charset="utf-8"></script>
    <script src="{{ asset('js/audioPlayer.js') }}" charset="utf-8"></script>
@endsection