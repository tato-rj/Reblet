@component('pages.files.panel.layout', ['title' => 'Edit file', 'id' => 'edit', 'file' => $file])
@form(['method' => 'PATCH', 'url' => route('files.update', $file), 'classes'])
	@input(['name' => 'given_name', 'label' => 'Original file name', 'value' => $file->given_name])
	@textarea(['name' => 'description', 'label' => 'Description', 'value' => $file->description, 'placeholder' => 'What\'s this file about?'])
	@submit(['label' => 'Save changes', 'theme' => 'primary'])
@endform
@endcomponent