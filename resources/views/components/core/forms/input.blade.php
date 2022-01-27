<div class="{{isset($type) && $type == 'hidden' ? null : 'form-group'}}">
	@isset($label)
	@label
	@endisset

	<input 
		type="{{$type ?? 'text'}}" 
		@isset($mask) data-mask="{{$mask}}" @endisset 
		placeholder="{{$placeholder ?? null}}" 
		name="{{$name}}" 
		value="{{$value ?? null}}" 
		{{$attr ?? null}}
		{{iftrue($required ?? null, 'required')}}
		class="form-control form-control-{{$size ?? null}} {{$classes ?? null}}" id="{{$id ??null}}" {{iftrue($readonly ?? null, 'readonly')}}>
	
	@isset($info)
	<div class="form-text">{{$info}}</div>
	@endisset
</div>