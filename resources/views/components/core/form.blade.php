<form method="{{in_array($method, ['DELETE', 'PATCH']) ? 'POST' : $method}}"
	@isset($id)
	id="{{$id}}" 
	@endisset
	@isset($data)
	@foreach($data as $type => $action)
	data-{{$type}}="{{$action}}"
	@endforeach
	@endisset
 	class="{{iftrue($borderless ?? null, 'form-borderless')}} form-{{$theme ?? 'light'}} {{$classes ?? null}}" action="{{$url}}">
	@csrf
	@method($method)

	{{$slot}}	

</form>