@extends('layouts.layout')

@section('title')
	| Discover podcasts
@endsection

@section('content')
	<div class="col-md-12">
		<h1 class="modal-header">Discover podcasts</h1>

		<div class="card-columns">
			@foreach ($discoverPodcasts as $podcast)
				<div class="card">
					<a href="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}">
						<img class="card-img-top" style="height: 275px;"  src="{{ url('/storage/image')}}/{{ $podcast->channel->image->image_file_name }}.{{ $podcast->channel->image->image_file_extension }}" alt="Podcast icon" title="{{ $podcast->podcast_title }}">
					</a>
					<div class="card-body">
						<h5 class="card-title">{{ $podcast->podcast_title }}</h5>
						<p class="card-text">
							@if (strlen($podcast->podcast_description) > 250)
								{{ substr($podcast->podcast_description, 0, 250) }}... <a href="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}">Read more</a>
							@else
								{{ $podcast->podcast_description }}
							@endif
						</p>
						<a href="/channel/{{ $podcast->channel->id }}/podcast/{{ $podcast->id }}" class="btn btn-primary btn-block mt-3">Listen to podcast</a>
					</div>
					<div class="card-footer">
						<small class="text-muted">
							{{ Helper::calculatePostTime($podcast->created_at) }} by <a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a>
						</small>
					</div>
				</div>
			@endforeach
		</div>
	</div>
@endsection