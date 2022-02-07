@btn(['icon' => ['name' => 'folder', 'position' => 'left'], 'theme' => 'outline-primary', 'label' => 'New folder', 'url' => null, 'modal' => 'new-folder-modal', 'classes' => 'btn-sm'])
@modal(['title' => 'Create new folder', 'id' => 'new-folder-modal'])
	@form(['method' => 'POST', 'url' => route('projects.folders.store', ['project' => $project, 'folder' => $folder]), 'borderless' => true])

	@input([
		'name' => 'name',
		'placeholder' => 'Folder name',
		'required' => true
	])

	@input([
		'name' => 'tag',
		'placeholder' => 'Tag (ex: Floor plans)',
		'required' => true
	])

	@textarea([
		'name' => 'description',
		'placeholder' => 'What is this folder for?',
	])

	@submit(['label' => 'Create folder', 'theme' => 'primary'])
	@endform
@endmodal