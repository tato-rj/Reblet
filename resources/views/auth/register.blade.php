@extends('layouts.app', ['title' => 'Register'])

@push('header')
@endpush

@section('content')
@container
	<div class="row">
		<div class="col-lg-4 col-md-6 col-8 mx-auto">
			@title(['title' => 'Register'])
			<div class="mb-3"> 
				@form(['method' => 'POST', 'url' => route('register'), 'data' => ['trigger' => 'loader']])
					@input([
						'label' => 'Full name',
						'name' => 'name', 
						'placeholder' => 'John Doe'])

					@input([
						'label' => 'Email address',
						'name' => 'email', 
						'type' => 'email', 
						'placeholder' => 'my@email.com',
						'info' => 'We\'ll never share your email with anyone else.'])

					@input([
						'label' => 'Password',
						'name' => 'password', 
						'type' => 'password',
						'placeholder' => '******'])

					@input([
						'label' => 'Confirm password',
						'name' => 'password_confirmation', 
						'type' => 'password',
						'placeholder' => '******'])

					@submit(['label' => 'Register', 'theme' => 'primary'])
				@endform
			</div>
			<a href="{{route('login')}}">Login to your account</a>
		</div>
	</div>
@endcontainer

@endsection

@push('scripts')
@endpush