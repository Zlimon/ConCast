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
				<input id="search" type="text" class="form-control @error('search') is-invalid @enderror" name="search" value="{{ old('search') }}" placeholder="" autofocus required>
				
				@error('search')
					<span class="invalid-feedback" role="alert">
						<strong>{{ $message }}</strong>
					</span>
				@enderror
			</div>

			<button type="submit" class="btn btn-primary mb-2"><i class="fas fa-search"></i></button>
		</form>

		@if ($query)
			<h1 class="modal-header">Search results for "{{ $query }}"</h1>

			<div class="card-columns">
				@foreach ($podcasts as $podcast)
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
		@endif
	</div>
@endsection