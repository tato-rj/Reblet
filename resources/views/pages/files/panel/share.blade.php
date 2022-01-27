@component('pages.files.panel.layout', ['title' => 'Share file', 'id' => 'share', 'file' => $file])
<div class="mb-3">
	@label(['label' => 'Copy link'])
	<div class="cursor-pointer" 
	data-bs-toggle="tooltip" 
	data-bs-trigger="manual"
	data-dynamic-clipboard-text="{{route('files.download', $file)}}"
	>@fa(['icon' => 'copy', 'fa_type' => 'r']){{route('files.download', $file)}}</div>
</div>

<div class="mb-3">
@form(['method' => '', 'url' => '#', 'classes' => 'share-file-form'])
	@label(['label' => 'Share by email'])
	@input(['type' => 'email', 'name' => 'recipient', 'placeholder' => 'Recipient\'s email', 'required' => true])
	<input type="hidden" name="subject" value="subject={{auth()->user()->name}} sent you a file">
	<input type="hidden" name="body" value="body=Hello,%0D%0APlease find the link below%0D%0A{{route('files.download', $file)}}">
	@submit(['icon' => ['name' => 'envelope', 'position' => 'left'], 'label' => 'Send', 'theme' => 'primary', 'classes' => 'btn-sm'])
@endform
</div>
@endcomponent