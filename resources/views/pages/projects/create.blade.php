@btn(['icon' => ['name' => 'magic', 'position' => 'left'], 'label' => 'Start a new project', 'theme' => 'primary', 'modal' => 'create-project-modal'])
@modal(['title' => 'New project', 'id' => 'create-project-modal'])
	@form(['method' => 'POST', 'url' => route('projects.store'), 'borderless' => true])
	@input([
		'name' => 'name',
		'placeholder' => 'Project name',
		'required' => true
	])
	@textarea([
		'name' => 'description',
		'placeholder' => 'What is this project about?',
	])

	@submit(['label' => 'Create project', 'theme' => 'primary'])
	@endform
@endmodal