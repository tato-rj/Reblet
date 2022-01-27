<div class="dropzone-container mb-4">
  <form saveFile="{{route('files.store', $revision)}}" 
        loadFiles="{{route('files.show', $revision)}}" 
        checkFile="{{route('files.exists', $revision)}}"
        data-path="{{$revision->path()}}" 
        presignedUrl="{{route('files.presignedUrl')}}" class="dropzone" id="drop-form-{{$revision->name}}">
    <div class="dz-message" data-dz-message><span>Drag and drop files here</span></div>
  </form>
</div>