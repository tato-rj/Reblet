@component('pages.files.panel.layout', ['title' => 'Comments', 'id' => 'comments', 'file' => $file])
<div class="comments-container mb-2" data-read-url="{{route('comments.read', ['comments' => $file->comments->pluck('id')->toArray()])}}" data-get-comment-url="{{route('comments.show')}}">
	@include('pages.comments.all', ['comments' => $file->comments])
</div>
<div id="typing" style="display: none">
	<div class="text-muted text-center mb-1" style="font-size: 68%"><i id="typer"></i></div>
<div class="typing-indicator mb-2 opacity-6">
  <span></span>
  <span></span>
  <span></span>
</div>
</div>
@form(['method' => 'POST', 'url' => route('comments.store', $file->revision->folder->project), 'classes' => 'chat-form'])
	<input type="hidden" name="model_type" value="{{get_class($file)}}">
	<input type="hidden" name="model_id" value="{{$file->id}}">
	@textarea(['name' => 'content', 'label' => 'Drop a comment below', 'rows' => 2, 'required' => true, 'max' => 240])

	@submit(['label' => 'Send', 'theme' => 'primary'])
@endform
@endcomponent