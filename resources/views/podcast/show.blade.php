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
                    <div class="col-md-3">
                        <img class="rounded" style="width: 100%;" src="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $podcast->podcast_title }}" width="256px" height="256px" />
                        <h2 class="mt-2"><a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a></h2>
                        <h4><strong>{{ number_format($podcast->channel->subscriptions->count()) }}</strong> subscribers</h4>
                        <p>Latest upload: {{ Helper::calculatePostTime($latestUpload->created_at) }}</p>

                        <div class="text-center">
                            @guest
                                <p><a class="btn btn-primary" href="/login">Log in to subsribe to this channel</a></p>
                            @else
                                @if (Helper::getUserSubscriber($podcast->channel->id))
                                    <form method="POST" action="/channel/{{ $podcast->channel->id }}/unsubscribe">
                                        @method('DELETE')
                                        @csrf

                                        <button class="btn btn-danger"><i class="fas fa-minus"></i> Unsubscribe</button>
                                    </form>
                                @else
                                    <form method="POST" action="/channel/{{ $podcast->channel->id }}/subscribe">
                                        @csrf

                                        <button class="btn btn-success"><i class="fas fa-plus"></i> Subscribe</button>
                                    </form>
                                @endif
                            @endguest
                        </div>
                    </div>

                    <div class="col-md-9">
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

                            <button class="btn btn-lg btn-primary"><i class="fas fa-share"></i> Share this podcast</button>
                        </div>

                        <div class="audio-player mt-3">
                            <audio id="audio" preload="auto" tabindex="0" controls="" type="audio/mpeg">
                            <source type="audio/mp3" src="{{ url('/storage/audio', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}">
                                Sorry, your browser does not support HTML5 audio.
                            </audio>
                            <ul id="playlist">
                                <li class="active">
                                    <a href="{{ url('/storage/audio', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <img class="rounded border border-dark" style="width: 75px;" src="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $podcast->channel->channel_name }}">
                                            </div>

                                            <div class="col-md-9">
                                                <strong>{{ $podcast->podcast_title }}</strong> {{ Helper::calculateAudioLength($podcast->audio->audio_file_length) }}
                                                <br>
                                                <small>
                                                    <span class="mr-4">{{ Helper::calculatePostTime($podcast->created_at) }}</span>
                                                    <span class="mr-2"><i class="fas fa-plus"></i> Play later</span>
                                                    <span class="mr-2"><i class="fas fa-save"></i> Save</span>
                                                    <span class="mr-2"><i class="fas fa-heart"></i> Like</span>
                                                    <span class="mr-2"><i class="fas fa-file-download"></i> Download</span>
                                                </small>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                                <li><h4 class="text-center border border-dark"><a href="">Download podcast</a></h4></li>
                            </ul>
                        </div>

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