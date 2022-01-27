<nav id="revisions-tab">
  <div class="nav nav-tabs mb-4">
    @foreach($folder->revisions as $revision)
    <a class="nav-link rounded-top {{$loop->last ? 'active' : null}}" id="nav-{{$revision->name}}-tab" data-dropzone="{{route('files.dropzone', $revision)}}" data-files-container="#files-container-{{$revision->id}}" data-bs-toggle="tab" href="#nav-{{$revision->name}}" >{{$revision->formattedName}}</a>
    @endforeach
  </div>
</nav>
<div class="tab-content">
  @foreach($folder->revisions as $revision)
  <div class="tab-pane revision-tab fade {{$loop->last ? 'show active' : null}}" id="nav-{{$revision->name}}">

    @if($loop->last)
      @include('components.dropzone')
    @endif

    <div class="files-container">
      @if($revision->files()->exists())
      @include('pages.files.table')
      @endif
    </div>

    <div class="d-flex"> 
      @form(['method' => 'POST', 'url' => route('revisions.increment', $folder), 'classes' => 'mr-3', 'data' => ['trigger' => 'loader']])
      @submit(['label' => 'Start a new revision', 'icon' => ['name' => 'plus', 'position' => 'left'], 'theme' => 'primary', 'classes' => 'btn-sm'])
      @endform

      @if($folder->revisions()->count() > 1)
          @delete(['item' => 'revision', 'target' => 'revision-'.$revision->id, 'url' => route('revisions.destroy', $revision)])
      @endif
    </div>
  </div>
  @endforeach
</div>