@extends('layouts.layout')

@section('title')
    | {{ $channel->channel_name }}
@endsection

@section('content')
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <span><a href="/">Home</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">Channel</a> <i class="fas fa-long-arrow-alt-right"></i> {{ $channel->channel_name }}</span>
                <span class="float-right"><a href="/channel/{{ $channel->id }}/edit"><i class="fas fa-edit"></i> Edit {{ $channel->channel_name }}</a></span>
            </div>

            <div class="card-body">
                <div class="row mb-3">
                    <div class="col-md-3">
                        <img class="rounded" style="width: 100%;" src="{{ url('/storage/image')}}/{{ $channel->image->image_file_name }}.{{ $channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $channel->channel_name }}">
                        
                        <div class="row no-gutters mt-3">
                            @guest
                                <div class="col-sm-6 col-md-12 text-center">
                                    <p><a class="btn btn-primary" href="/login">Log in to subsribe to this channel</a></p>
                                </div>
                            @endguest

                            <div class="col-md-6">
                                <h5 style="line-height: 1.75; margin: 0;"><strong>{{ number_format($channel->subscriptions->count()) }}</strong> subscribers</h5>
                            </div>

                            <div class="col-md-6">
                                @guest
                                @else
                                    @if (Helper::getUserSubscriber($channel->id))
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
                        </div>
                    </div>

                    <div class="col-md-9">
                        <div class="row">
                            <div class="col-md-12">
                                <h1 class="input-group">{{ $channel->channel_name }}</h1>
                            </div>
                        </div>

                        <div class="row no-gutters">
                            <div class="col-sm-7 col-md-9">
                                @if ($channel->channel_bio)
                                    <p>{{ $channel->channel_bio }}</p>
                                @else
                                    <p><em>No channel bio</em></p>
                                @endif

                                <button class="btn btn-lg btn-primary"><i class="fas fa-share"></i> Share this podcast channel</button>
                            </div>

                            <div class="col-sm-5 col-md-3 text-right">
                                <ul style="list-style: none;">
                                    <li>
                                        @if ($channel->channel_email)
                                            {{ $channel->channel_email }}
                                        @else
                                            <em>Secret</em>
                                        @endif
                                        <i style="font-size: 2em; vertical-align: middle;" class="fas fa-envelope-square ml-1"></i>
                                    </li>
                                    <li>
                                        @if ($channel->channel_facebook)
                                            <a target="_blank" rel="noopener noreferrer" href="{{ $channel->channel_facebook }}">{{ $channel->channel_facebook }}</a>
                                        @else
                                            <em>Secret</em>
                                        @endif
                                        <i style="font-size: 2em; vertical-align: middle;" class="fab fa-facebook-square ml-1"></i>
                                    </li>
                                    <li>
                                        @if ($channel->channel_twitter)
                                            <a target="_blank" rel="noopener noreferrer" href="{{ $channel->channel_twitter }}">{{ $channel->channel_twitter }}</a>
                                        @else
                                            <em>Secret</em>
                                        @endif
                                        <i style="font-size: 2em; vertical-align: middle;" class="fab fa-twitter-square ml-1"></i>
                                    </li>
                                    <li>Created {{ \Carbon\Carbon::parse($channel->created_at)->format('d. M Y') }}</li>
                                    <li>Last upload: {{ ($channel->podcasts->count() ? Helper::calculatePostTime($channel->podcasts->last()->created_at) : 'Never') }}</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                @if ($channel->podcasts->count())
                    <div class="audio-player">
                        <audio id="audio" preload="auto" tabindex="0" controls="" type="audio/mpeg">
                        <source type="audio/mp3" src="{{ url('/storage/audio', $channel->podcasts->first()->audio->audio_file_name . '.' . $channel->podcasts->first()->audio->audio_file_extension) }}">
                            Sorry, your browser does not support HTML5 audio.
                        </audio>
                        <ul id="playlist">
                            @foreach ($channel->podcasts as $podcast)
                                @if ($loop->first)
                                    <li class="active">
                                        <a href="{{ url('/storage/audio', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}">
                                            <div class="row">
                                                <div class="col-md-1">
                                                    <img class="rounded border border-dark" style="width: 75px;" src="{{ url('/storage/image')}}/{{ $channel->image->image_file_name }}.{{ $channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $channel->channel_name }}">
                                                </div>

                                                <div class="col-md-9">
                                                    <strong>{{ $podcast->podcast_title }}</strong> {{ Helper::calculateAudioLength($podcast->audio->audio_file_length) }}
                                                    <br>
                                                    <span>{{ $podcast->podcast_description }}</span>
                                                    <br>
                                                    <small>
                                                        <span class="mr-4">{{ Helper::calculatePostTime($podcast->created_at) }}</span>
                                                        <span class="mr-2"><i class="fas fa-plus"></i> Play later</span>
                                                        <span class="mr-2"><i class="fas fa-save"></i> Save</span>
                                                        <span class="mr-2"><i class="fas fa-heart"></i> Like</span>
                                                        <span class="mr-2"><i class="fas fa-file-download"></i> Download</span>
                                                    </small>
                                                </div>

                                                <div class="col-md-2 text-center">
                                                    <button class="btn btn-success" onclick="window.location.href = '/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}';">Visit podcast page</button>
                                                    <br>
                                                    <small>This enables you to rate and comment the podcast</small>

                                                    <button class="btn btn-success" type="submit"><i class="fa fa-download"></i> Download</button>
                                                </div>
                                            </div>
                                        </a>
                                    </li>

                                    @continue
                                @endif
                                <li>
                                    <a href="{{ url('/storage/audio', $podcast->audio->audio_file_name . '.' . $podcast->audio->audio_file_extension) }}">
                                        <div class="row">
                                            <div class="col-md-1">
                                                <img class="rounded border border-dark" style="width: 75px;" src="{{ url('/storage/image')}}/{{ $channel->image->image_file_name }}.{{ $channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $channel->channel_name }}">
                                            </div>

                                            <div class="col-md-9">
                                                <strong>{{ $podcast->podcast_title }}</strong> {{ Helper::calculateAudioLength($podcast->audio->audio_file_length) }}
                                                <br>
                                                <span>{{ $podcast->podcast_description }}</span>
                                                <br>
                                                <small>
                                                    <span class="mr-4">{{ Helper::calculatePostTime($podcast->created_at) }}</span>
                                                    <span class="mr-2"><i class="fas fa-plus"></i> Play later</span>
                                                    <span class="mr-2"><i class="fas fa-save"></i> Save</span>
                                                    <span class="mr-2"><i class="fas fa-heart"></i> Like</span>
                                                    <span class="mr-2"><i class="fas fa-file-download"></i> Download</span>
                                                </small>
                                            </div>

                                            <div class="col-md-2 text-center">
                                                <button class="btn btn-success" onclick="window.location.href = '/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}';">Visit podcast page</button>
                                                <br>
                                                <small>This enables you to rate and comment the podcast</small>

                                                <button class="btn btn-success" type="submit"><i class="fa fa-download"></i> Download</button>
                                            </div>
                                        </div>
                                    </a>
                                </li>
                            @endforeach
                            <li><h4 class="text-center border border-dark"><a href="">Download all podcasts</a></h4></li>
                        </ul>
                    </div>
                @else
                    <p class="text-center">This channel doesn't have any content</p>
                @endif
            </div>
        </div>
    </div>

    <script src="{{ asset('js/audio.js')}}"></script>
@endsection