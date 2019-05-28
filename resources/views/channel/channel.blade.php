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
					<a href="/channel/{{ $channel->id }}">
						<img class="card-img-top" style="height: 275px;" src="{{ url('/storage/image')}}/{{ $channel->image->image_file_name }}.{{ $channel->image->image_file_extension }}" alt="Channel image" title="{{ $channel->channel_name }}">
					</a>
					<div class="card-body">
						<h5 class="card-title">{{ $channel->channel_name }}</h5>
						<p class="card-text"><b>
							@if (strlen($channel->channel_bio) > 250)
								{{ substr($channel->channel_bio, 0, 250) }}... <a href="/channel/{{ $channel->id }}">Read more</a>
							@else
								{{ $channel->channel_bio }}
							@endif
						</b></p>
						<a href="/channel/{{ $channel->id }}" class="btn btn-primary btn-block mt-3">Visit channel</a>
					</div>
					<div class="card-footer">
						<small class="text-muted">Last active {{ ($channel->podcasts->count() ? Helper::calculatePostTime($channel->podcasts->last()->created_at) : 'Never') }}</small>
						<small>{{ number_format($channel->subscriptions->count()) }} subscribers - {{ $channel->podcasts->count() }} podcasts</small>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection