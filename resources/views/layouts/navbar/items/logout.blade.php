<form  method="POST" action="{{route('logout')}}">
	@csrf
<a class="nav-link text-wrap py-{{$height ?? null}} px-{{$gap ?? null}} hover-{{$hover ?? null}}" href="{{route('logout')}}" onclick="event.preventDefault(); this.closest('form').submit()">
	@fa(['icon' => 'sign-out-alt', 'color' => 'auto', 'classes' => 'nav-link-icon'])
</a>
</form>