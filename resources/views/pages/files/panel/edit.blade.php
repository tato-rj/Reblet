@component('pages.files.panel.layout', ['title' => 'Edit file', 'id' => 'edit', 'file' => $file])
@form(['method' => 'PATCH', 'url' => route('files.update', $file), 'classes'])
	@input(['name' => 'custom_name', 'label' => 'Custom name', 'value' => $file->custom_name, 'placeholder' => 'Ovewrite the file name here'])
	@textarea(['name' => 'description', 'label' => 'Description', 'value' => $file->description, 'placeholder' => 'What\'s this file about?'])
	@submit(['label' => 'Save changes', 'theme' => 'primary'])
@endform
@endcomponent