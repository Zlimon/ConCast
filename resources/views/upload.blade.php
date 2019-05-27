@extends('layouts.layout')

@section('title')
    | {{ __('title.upload') }}
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> {{ __('title.upload') }}</span>
            </div>

            <div class="card-body">
                <h1>{{ __('title.upload') }}</h1>

                {!! Form::open(array('url' => '/upload', 'files' => 'true')) !!}
                    <div class="form-group">
                        <div class="span2 well">
                            <div class="border rounded p-2 {{ $errors->isEmpty() ? '' : 'is-invalid' }}">
                                <label for="podcastAudio">Audio file</label>
                                <br>
                                {!! Form::file('audio', array('class' => 'audio')) !!}
                            </div>
                        </div>
                        <br>
                        <div class="span2 well">
                            <div class="border rounded p-2 {{ $errors->isEmpty() ? '' : 'is-invalid' }}">
                                <label for="podcastImage">Image file</label>
                                <br>
                                {!! Form::file('image', array('class' => 'image')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="podcast_title">Title</label>
                        <input type="text" class="form-control {{ $errors->has('podcast_title') ? 'is-invalid' : '' }}" name="podcast_title" id="podcast_title" aria-describedby="titleDesc" value="{{ old('podcast_title') }}" required>
                        <!-- <small id="titleDesc" class="form-text text-muted">Edgy content</small> -->

                        @if ($errors->has('podcast_title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('podcast_title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="podcast_description">Description</label>
                        <input type="text" class="form-control {{ $errors->has('podcast_description') ? 'is-invalid' : '' }}" name="podcast_description" id="podcast_description" value="{{ old('podcast_description') }}" required>

                        @if ($errors->has('podcast_description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('podcast_description') }}</strong>
                            </span>
                        @endif
                    </div>

                    
                    <div class="form-group">
                        <label for="channel_id">Which channel to post on?</label>
                        @foreach ($channels as $channel)
                            <div class="form-check">
                                <input type="radio" class="form-check-input {{ $errors->has('channel_id') ? 'is-invalid' : '' }}" name="channel_id" id="podcastChanne{{ $channel->id }}" value="{{ $channel->id }}" checked>
                                <label class="form-check-label" for="podcastChanne{{ $channel->id }}">
                                    {{ $channel->channel_name }}
                                </label>
                            </div>
                        @endforeach

                        @if ($errors->has('channel_id'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('channel_id') }}</strong>
                            </span>
                        @endif
                    </div>

                    <!-- <div class="form-group">
                        <label for="podcastCategroy">Category</label>
                        <input type="text" class="form-control" id="podcastCategroy" name="podcastCategory" placeholder="Category" value="test">
                    </div> -->

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block mt-3">Upload</button>
                    </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@endsection