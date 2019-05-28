@extends('layouts.layout')

@section('title')
	| {{ __('title.discover') }}
@endsection

@section('content')
	<div class="col-md-12">
		<div class="text-center">
			<h1>Search for channels and podcasts</h1>
		</div>

		<form class="form-group row" method="POST" action="/search">
			@csrf

			<div class="col-md-3"></div>

			<div class="col-md-6 mb-2">
				<input id="search" type="text" class="form-control @error('search') is-invalid @enderror" name="search" value="{{ old('search') }}" autofocus required>
				
				@error('search')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i></button>
		</form>

		@if ($searchQuery)
			<h1 class="ml-3">Search results for "{{ $searchQuery }}"</h1>
			<span class="modal-header mb-3">Found {{ count($channels) }} channels and {{ count($podcasts) }} podcasts</span>

			<div class="card-columns">
				@foreach ($podcasts as $podcast)
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
								{{ Helper::calculatePostTime($podcast->created_at) }}
								by
								<a href="/channel/{{ $podcast->channel->id }}">{{ $podcast->channel->channel_name }}</a>
							</small>
						</div>
					</div>
				@endforeach

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
		@endif
	</div>
@endsection