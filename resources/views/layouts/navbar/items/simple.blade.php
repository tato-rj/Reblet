@php($is_route = is_route($route ?? null))
<a class="nav-link animate__animated text-wrap py-{{$height ?? null}} px-{{$gap ?? null}} hover-{{$hover ?? null}} {{$is_route ? 'active' : null}}"  		@isset($id)
		id="{{$id}}"
		@endisset 
	aria-current="page" 
	href="{{isset($route) ? route($route) : '#'}}">
@isset($icon)
@fa(['icon' => $icon, 'color' => 'auto', 'classes' => 'nav-link-icon'])
@endisset
<span>{{$label ?? null}}</span></a>