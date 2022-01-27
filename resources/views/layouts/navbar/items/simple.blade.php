@php($is_route = is_route($route ?? null))
<a class="nav-link text-wrap py-{{$menu['height'] ?? null}} px-{{$menu['gap'] ?? null}} hover-{{$menu['hover'] ?? null}} {{$is_route ? 'active' : null}}"  
	aria-current="page" 
	href="{{isset($route) ? route($route) : '#'}}">
@isset($icon)
@fa(['icon' => $icon, 'color' => 'auto', 'classes' => 'nav-link-icon'])
@endisset
<span>{{$label ?? null}}</span></a>