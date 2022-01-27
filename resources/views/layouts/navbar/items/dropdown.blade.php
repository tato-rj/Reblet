@php($hasActiveRoute = false)

@foreach($item['dropdown'] as $dropdown)
	@if(! $hasActiveRoute)
	@php($hasActiveRoute = is_route($dropdown['route'] ?? null))
	@endif
@endforeach

<li class="nav-item dropdown {{iftrue($menu['slide'] ?? null, 'slide')}}">
	<a class="nav-link dropdown-toggle py-{{$menu['height'] ?? null}} px-{{$menu['gap'] ?? null}} hover-{{$menu['hover'] ?? null}} d-apart" data-bs-toggle="dropdown" href="#">
		<div>
			@isset($icon)
			@fa(['icon' => $icon, 'color' => 'auto'])
			@endisset
			<span>{{$label ?? null}}</span>
		</div>
		<div class="dropdown-caret t-2 ml-2">@fa(['icon' => 'chevron-down', 'mr' => 0, 'classes' => null])</div>
	</a>

	<ul class="dropdown-menu m-0 bg-{{$menu['background'] ?? null}} animate__animated animate__{{$menu['animation'] ?? null}}">
		@foreach($item['dropdown'] as $dropdown)
		@php($is_route = is_route($dropdown['route'] ?? null))
		<li><a class="nav-link py-{{$menu['dropdown']['height'] ?? null}} px-{{$menu['dropdown']['gap'] ?? null}} hover-{{$menu['dropdown']['hover'] ?? null}} {{$is_route ? 'active' : null}}" href="{{isset($dropdown['route']) ? route($dropdown['route']) : '#'}}">{{$dropdown['label']}}</a></li>
		@endforeach
	</ul>
</li>
@php($hasActiveRoute = false)