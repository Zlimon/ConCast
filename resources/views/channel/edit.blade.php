@extends('layouts.layout')

@section('title')
    | Edit channel
@endsection

@section('content')
    <div class="col-md-8">
        <div class="card">
            <div class="card-header">
                <span><a href="/">Home</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel">Channel</a> <i class="fas fa-long-arrow-alt-right"></i> <a href="/channel/{{ $channel->id }}">{{ $channel->channel_name }}</a> <i class="fas fa-long-arrow-alt-right"></i> Edit channel</span>
            </div>

            <div class="card-body">
                <h1>Edit channel</h1>

                <form method="POST" action="/channel/{{ $channel->id }}">
                    @method('PATCH')
                    @csrf

                    <div class="form-group">
                        <label for="channel_name">Name</label>
                        <input type="text" class="form-control @error('channel_name') border-danger @enderror" name="channel_name" id="channel_name" placeholder="Channel name" value="{{ $channel->channel_name }}" required>

                        @if ($errors->has('channel_name'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('channel_name') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="channel_bio">Bio</label>
                        <input type="text" class="form-control @error('channel_bio') border-danger @enderror" name="channel_bio" id="channel_bio" placeholder="Channel bio" value="{{ $channel->channel_bio }}">

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