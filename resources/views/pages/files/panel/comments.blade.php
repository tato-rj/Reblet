@component('pages.files.panel.layout', ['title' => 'Comments', 'id' => 'comments', 'file' => $file])
<div class="comments-container mb-4">
	@include('pages.comments.all', ['comments' => $file->comments])
</div>
@form(['method' => 'POST', 'url' => route('comments.store'), 'classes' => 'chat-form'])
	<input type="hidden" name="model_type" value="{{get_class($file)}}">
	<input type="hidden" name="model_id" value="{{$file->id}}">
	@textarea(['name' => 'content', 'label' => 'Drop a comment below', 'rows' => 2, 'required' => true, 'max' => 240])

	@submit(['label' => 'Send', 'theme' => 'primary'])
@endform
@endcomponent