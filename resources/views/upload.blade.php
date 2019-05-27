@extends('layouts.layout')

@section('title')
    | Upload podcast
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><a href="/">Home</a> <i class="fas fa-long-arrow-alt-right"></i> Upload podcast</span>
            </div>

            <div class="card-body">
                <h1>Upload podcast</h1>

                <form method="POST" action="/upload" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="audio">Audio file</label>
                        <input type="file" class="form-control-file border rounded p-1 @error('audio') border-danger @enderror" name="audio" id="audio" required>

                        @if ($errors->has('audio'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('audio') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="podcast_title">Title</label>
                        <input type="text" class="form-control @error('podcast_title') border-danger @enderror" name="podcast_title" id="podcast_title" value="{{ old('podcast_title') }}" required>

                        @if ($errors->has('podcast_title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('podcast_title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="podcast_description">Description</label>
                        <input type="text" class="form-control @error('podcast_description') border-danger @enderror" name="podcast_description" id="podcast_description" value="{{ old('podcast_description') }}" required>

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
                                <input type="radio" class="form-check-input @error('channel_id') border-danger @enderror" name="channel_id" id="podcastChanne{{ $channel->id }}" value="{{ $channel->id }}" checked>
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
                </form>
            </div>
        </div>
    </div>
@endsection