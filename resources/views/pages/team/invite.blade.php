@if($team->leader()->is(auth()->user()))
@btn(['icon' => ['name' => 'user', 'position' => 'left'], 'theme' => 'outline-primary', 'label' => 'Invite new member', 'url' => null, 'modal' => 'invite-member-modal', 'classes' => 'btn-sm'])
@modal(['title' => 'Create new folder', 'id' => 'invite-member-modal'])
	@form(['method' => 'POST', 'url' => route('projects.team.invite', $team->project), 'borderless' => true, 'data' => ['trigger' => 'loader']])

	@input([
		'name' => 'name',
		'placeholder' => 'Recipient\'s name',
		'required' => true
	])

	@input([
		'name' => 'email',
		'type' => 'email',
		'placeholder' => 'Recipient\'s email',
		'required' => true
	])

	@submit(['label' => 'Send out invitation', 'theme' => 'primary'])
	@endform
@endmodal
@endif