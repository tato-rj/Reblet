@extends('layouts.app', ['title' => str_possessive($team->project->name) . ' team'])

@push('header')
@endpush

@section('content')
@container

<div class="mb-4">
	@back(['url' => route('projects.folders.show', ['project' => $team->project, 'folder' => $team->project->folders()->home()]), 'pagename' => 'project'])
	<h3>@fa(['icon' => 'users', 'fa_color' => 'muted']){{$team->project->name}}'s Team</h3>
</div>
<div>
	@include('pages.team.table')
</div>
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
@endcontainer
@endsection

@push('scripts')
@endpush