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
@include('pages.team.invite')
@endcontainer
@endsection

@push('scripts')
@endpush