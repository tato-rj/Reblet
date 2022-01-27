<div class="form-group">
  @isset($label)
  <label class="form-label">{{$label}}</label>
  @endisset

  <select 
    class="form-select form-select-{{$size ?? null}} {{$classes ?? null}}" 
    name="{{$name}}" id="{{$id ??null}}" 
    {{iftrue($required ?? null, 'required')}}
    {{iftrue($readonly ?? null, 'readonly')}}>
    
    @isset($placeholder)
    <option selected value="">{{$placeholder}}</option>
    @endisset

    {{$slot}}

  </select>
  
  @isset($info)
  <div class="form-text">{{$info}}</div>
  @endisset
</div>