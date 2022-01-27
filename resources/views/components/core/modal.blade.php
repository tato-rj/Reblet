<div class="modal fade" id="{{$id}}">
  <div class="modal-dialog">
    <div class="modal-content rounded modal-{{$size ?? null}}">
      <div class="modal-header border-0">
        <h5 class="modal-title">{{$title}}</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        {{$slot}}
      </div>

      @isset($footer)
      <div class="modal-footer">
        {{$footer}}
      </div>
      @endisset
    </div>
  </div>
</div>