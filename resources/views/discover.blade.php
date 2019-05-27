@extends('layouts.layout')

@section('title')
    | {{ __('title.discover') }}
@endsection

@section('content')
    <div class="col-md-12">
        <h1 class="modal-header">{{ __('title.discover') }}</h1>

        <div class="card-columns">
            @foreach ($discoverPodcasts as $podcast)
                <div class="card">
                    <img class="card-img-top" src="{{ url('/storage')}}/{{ $podcast->image->image_file_name }}.{{ $podcast->image->image_file_extension }}" alt="Podcast icon" title="{{ $podcast->podcast_title }}" width="150px" height="150px" />
                    <div class="card-body">
                        <h5 class="card-title">{{ $podcast->podcast_title }}</h5>
                        <p class="card-text">
                            @if (strlen($podcast->podcast_description) > 250)
                                {{ substr($podcast->podcast_description, 0, 250) }}...
                            @else
                                {{ $podcast->podcast_description }}
                            @endif
                        </p>
                        <a href="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}" class="btn btn-primary btn-block mt-3">Visit podcast</a>
                    </div>
                    <div class="card-footer">
                        <small class="text-muted">
                            {{ \ConCast\Http\Controllers\CalculateTime::calculatePostTime($podcast->created_at) }}
                            by
                            <a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a>
                        </small>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection