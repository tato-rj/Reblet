<div class="form-group">
    @isset($label)
    @label
    @endisset

    <div>
        @foreach($options as $value => $label)
        <div class="form-check {{iftrue($inline ?? null, 'form-check-inline')}} {{$classes ?? null}}">
          <input 
            class="form-check-input" 
            name="{{$name}}" 
            type="radio" 
            value="{{$value}}" 
            id="radio-{{$value}}" 
            {{iftrue($required ?? null, 'required')}}
            {{iftrue($readonly ?? null, 'readonly')}}>
          <label class="form-check-label" for="radio-{{$value}}">{{$label}}</label>
        </div>
        @endforeach
    </div>

    @isset($info)
    <div class="form-text">{{$info}}</div>
    @endisset
</div>