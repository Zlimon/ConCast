@extends('layouts.layout')

@section('title')
    | Edit podcast
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><a href="/">Home</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">Channel</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel/{{ $podcast->channel->id }}/podcast/ {{ $podcast->id }}">{{ $podcast->podcast_title }}</a> <i class="fas fa-long-arrow-alt-right"></i> Edit podcast</span>
            </div>

            <div class="card-body">
                <h1>Edit podcast</h1>

                <form method="POST" action="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}">
                    @method('PATCH')
                    @csrf

                    <div class="form-group">
                        <label for="podcast_title">Title</label>
                        <input type="text" class="form-control @error('podcast_title') border-danger @enderror" name="podcast_title" id="podcast_title" placeholder="Podcast title" value="{{ $podcast->podcast_title }}" required>

                        @if ($errors->has('podcast_title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('podcast_title') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="podcast_description">Description</label>
                        <input type="text" class="form-control @error('podcast_description') border-danger @enderror" name="podcast_description" id="podcast_description" placeholder="Podcast description" value="{{ $podcast->podcast_description }}" required>

                        @if ($errors->has('podcast_description'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('podcast_description') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-success btn-lg btn-block mt-3">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection