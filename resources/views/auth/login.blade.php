@extends('layouts.app', ['title' => 'Login'])

@push('header')
@endpush

@section('content')
@container
	<div class="row">
		<div class="col-lg-4 col-md-6 col-8 mx-auto">
			@title(['title' => 'Login'])
			<div class="mb-3"> 
				@form(['method' => 'POST', 'url' => route('login'), 'data' => ['trigger' => 'loader']])
					@input([
						'label' => 'Email address',
						'name' => 'email', 
						'type' => 'email', 
						'placeholder' => 'my@email.com'])

					@input([
						'label' => 'Password',
						'name' => 'password', 
						'type' => 'password',
						'placeholder' => '******'])

					@submit(['label' => 'Login', 'theme' => 'primary'])
				@endform
			</div>
			<a href="{{route('register')}}">Create new account</a>
		</div>
	</div>
@endcontainer

@endsection

@push('scripts')
@endpush