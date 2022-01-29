<li class="nav-item dropdown {{iftrue($slide ?? null, 'slide')}}">
	<a class="nav-link animate__animated dropdown-toggle py-{{$height ?? null}} px-{{$gap ?? null}} hover-{{$hover ?? null}} d-apart" data-bs-toggle="dropdown" href="#">
		<div>
			@isset($icon)
			@fa(['icon' => $icon, 'color' => 'auto'])
			@endisset
			<span>{{$label ?? null}}</span>
		</div>
		<div class="dropdown-caret t-2 ml-2">@fa(['icon' => 'chevron-down', 'mr' => 0, 'classes' => null])</div>
	</a>

	<ul class="dropdown-menu m-0 bg-{{$background ?? null}} animate__animated animate__{{$animation ?? null}}">
		
		{{$slot}}

	</ul>
</li>