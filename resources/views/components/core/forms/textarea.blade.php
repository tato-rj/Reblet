<div class="form-group">
	@isset($label)
	@label
	@endisset

	<textarea 
		class="form-control form-control-{{$size ?? null}} {{$classes ?? null}}" 
		id="{{$id ??null}}" 
		rows="{{$rows ?? 4}}" 
		{{iftrue($readonly ?? null, 'readonly')}} 
		{{iftrue($required ?? null, 'required')}}
		name="{{$name}}" 
		maxlength="{{$max ?? null}}" 
		placeholder="{{$placeholder ?? null}}">{{$value ?? null}}</textarea>
	
	@isset($info)
	<div class="form-text">{{$info}}</div>
	@endisset
</div>