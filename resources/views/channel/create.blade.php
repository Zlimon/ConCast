@extends('layouts.layout')

@section('title')
    | {{ __('title.create-channel') }}
@endsection

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <span><a href="/">{{ __('title.home') }}</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">{{ __('title.channel') }}</a> <i class="fas fa-long-arrow-alt-right"></i> {{ __('title.create-channel') }}</span>
                    </div>

                    <div class="card-body">
                        <h1>{{ __('title.create-channel') }}</h1>

                        <form method="POST" action="/channel">
                            @csrf

                            <div class="form-group">
                                <label for="channel_name">Channel name</label>
                                <input type="text" class="form-control {{ $errors->has('channel_name') ? 'is-invalid' : '' }}" name="channel_name" id="channel_name" value="{{ old('channel_name') }}" required>

                                @if ($errors->has('channel_name'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('channel_name') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="channel_bio">Channel bio</label>
                                <input type="text" class="form-control {{ $errors->has('channel_bio') ? 'is-invalid' : '' }}" name="channel_bio" id="channel_bio" value="{{ old('channel_bio') }}">

                                @if ($errors->has('channel_bio'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('channel_bio') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="channel_bio">Contact email</label>
                                <input type="text" class="form-control {{ $errors->has('channel_email') ? 'is-invalid' : '' }}" name="channel_email" id="channel_email" value="{{ old('channel_email') }}">

                                @if ($errors->has('channel_email'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('channel_bio') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="channel_bio">Facebook</label>
                                <input type="text" class="form-control {{ $errors->has('channel_facebook') ? 'is-invalid' : '' }}" name="channel_facebook" id="channel_facebook" value="{{ old('channel_facebook') }}">

                                @if ($errors->has('channel_facebook'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('channel_facebook') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="channel_bio">Twitter</label>
                                <input type="text" class="form-control {{ $errors->has('channel_twitter') ? 'is-invalid' : '' }}" name="channel_twitter" id="channel_twitter" value="{{ old('channel_twitter') }}">

                                @if ($errors->has('channel_twitter'))
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('channel_twitter') }}</strong>
                                    </span>
                                @endif
                            </div>

                            <div class="form-group">
                                <button type="submit" class="btn btn-primary btn-lg btn-block mt-3">Create</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection