@extends('layouts.layout')

@section('title')
    | Discover channels
@endsection

@section('content')
    <div class="col-md-12">
        <h1 class="modal-header">Discover channels</h1>

        <div class="card-columns">
            @foreach ($channels as $channel)
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{{ $channel->channel_name }}</h5>
                        <p class="card-text"><b>{{ $channel->channel_bio }}</b></p>
                        <p class="card-text">{{ number_format($channel->subscriptions->count()) }} subscribers - {{ $channel->podcasts->count() }} podcasts</p>
                        <a href="/channel/{{ $channel->id }}" class="btn btn-primary btn-block mt-3">Visit channel</a>
                    </div>
                    @if ($latestUpload)
                        <div class="card-footer">
                            <small class="text-muted">Last active {{ Helper::calculatePostTime($latestUpload->created_at) }}</small>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
@endsection