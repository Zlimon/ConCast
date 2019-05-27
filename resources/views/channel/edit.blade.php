@extends('layouts.layout')

@section('title')
    | {{ __('title.edit-channel') }}
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">{{ __('title.channel') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel/{{ $channel->id }}">{{ $channel->channel_name }}</a> <i class="fas fa-long-arrow-alt-right"></i> {{ __('title.edit-channel') }}</span>
            </div>

            <div class="card-body">
                <h1>{{ __('title.edit-channel') }} <b>{{ $channel->channel_name }}</b></h1>

                <form method="POST" action="/channel/{{ $channel->id }}">
                    @method('PATCH')
                    @csrf

                    <div class="form-group">
                        <label for="channel_name">New channel name</label>
                        <input type="text" class="form-control {{ $errors->has('channel_name') ? 'is-invalid' : '' }}" name="channel_name" id="channel_name" placeholder="Channel name" value="{{ $channel->channel_name }}" required>

                        @if ($errors->has('channel_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('channel_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="channel_bio">New channel bio</label>
                        <input type="text" class="form-control {{ $errors->has('channel_bio') ? 'is-invalid' : '' }}" name="channel_bio" id="channel_bio" placeholder="Channel bio" value="{{ $channel->channel_bio }}">

                        @if ($errors->has('channel_bio'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('channel_bio') }}</strong>
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