@extends('layouts.layout')

@section('title')
    | {{ __('title.edit-podcast') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">{{ __('title.channel') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel/{{ $podcast->channel->id }}/podcast/ {{ $podcast->id }}">{{ $podcast->podcast_title }}</a> <i class="fas fa-long-arrow-alt-right"></i> {{ __('title.edit-podcast') }}</span>
                    </div>

                    <div class="card-body">
                        <h1>{{ __('title.edit-podcast') }} <b>{{ $podcast->podcast_title }}</b></h1>

                        <form method="POST" action="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}">
                            @method('PATCH')
                            @csrf

                            <div class="form-group">
                                <label for="podcast_title">New podcast title</label>
                                <input type="text" class="form-control {{ $errors->has('podcast_title') ? 'is-invalid' : '' }}" name="podcast_title" id="podcast_title" placeholder="Channel name" value="{{ $podcast->podcast_title }}" required>

                                @if ($errors->has('podcast_title'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('podcast_title') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="podcast_description">New podcast description</label>
                                <input type="text" class="form-control {{ $errors->has('podcast_description') ? 'is-invalid' : '' }}" name="podcast_description" id="podcast_description" placeholder="Channel description" value="{{ $podcast->podcast_description }}" required>

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
        </div>
    </div>
@endsection