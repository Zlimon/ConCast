@extends('layouts.layout')

@section('title')
    | Create channel
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><a href="/">Home</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">Channel</a> <i class="fas fa-long-arrow-alt-right"></i> Create channel</span>
            </div>

            <div class="card-body">
                <h1>Create channel</h1>

                <form method="POST" action="/channel" enctype="multipart/form-data">
                    @csrf

                    <div class="form-group">
                        <label for="image">Image file</label>
                        <input type="file" class="form-control-file border rounded p-1 @error('image') border-danger @enderror" name="image" id="image" required>

                        @if ($errors->has('image'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="channel_name">Channel name</label>
                        <input type="text" class="form-control @error('channel_name') border-danger @enderror" name="channel_name" id="channel_name" value="{{ old('channel_name') }}" required>

                        @if ($errors->has('channel_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('channel_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="channel_bio">Channel bio</label>
                        <input type="text" class="form-control @error('channel_bio') border-danger @enderror" name="channel_bio" id="channel_bio" value="{{ old('channel_bio') }}">

                        @if ($errors->has('channel_bio'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('channel_bio') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="channel_bio">Contact email</label>
                        <input type="email" class="form-control @error('channel_email') border-danger @enderror" name="channel_email" id="channel_email" value="{{ old('channel_email') }}">

                        @if ($errors->has('channel_email'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('channel_bio') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="channel_bio">Facebook</label>
                        <input type="text" class="form-control @error('channel_facebook') border-danger @enderror" name="channel_facebook" id="channel_facebook" value="{{ old('channel_facebook') }}">

                        @if ($errors->has('channel_facebook'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('channel_facebook') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="channel_bio">Twitter</label>
                        <input type="text" class="form-control @error('channel_twitter') border-danger @enderror" name="channel_twitter" id="channel_twitter" value="{{ old('channel_twitter') }}">

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
@endsection