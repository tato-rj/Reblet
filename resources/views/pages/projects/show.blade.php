@extends('layouts.app', ['title' => $project->name])

@push('header')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style type="text/css">
.dropzone-container {
	border-style: dashed !important;
}


</style>
@endpush

@section('content')
@container

<div class="row"> 
	<div class="col-6"> 
		@back(['url' => route('projects.index'), 'pagename' => 'projects'])
		<div class="pb-4 mb-4 border-bottom">
			@title([
				'title' => $project->name,
				'icon' => ['name' => 'desktop'],
				'subtitle' => 'Project created by ' . $project->creator->name,
				'description' => $project->description
			])

			<div class="mb-4">
				@label(['label' => 'Created at'])
				<div>@fa(['icon' => 'calendar-alt', 'fa_color' => 'muted']){{$project->created_at->toFormattedDateString()}}</div>
			</div>

			<div>
				@label(['label' => str_possessive($project->name).' team'])
				@foreach($project->team->members as $member)
				<div>{!!$member->avatar()!!}{{$member->name}}</div>
				@endforeach
			</div>
		</div>

		<div class="d-inline-block">
			<div class="mb-2">
				@btn(['label' => 'Go to project', 'icon' => ['position' => 'left', 'name' => 'desktop'], 'theme' => 'primary', 'url' => route('projects.folders.show', ['project' => $project, 'folder' => $project->folders()->home()])])
			</div>

			@if(auth()->user()->can('update', $project))
			@btn(['icon' => ['name' => 'trash-alt', 'position' => 'left'], 'label' => 'Delete project', 'theme' => 'outline-red', 'url' => null, 'modal' => 'project-'.$project->id])
			@modal(['title' => 'Delete project', 'id' => 'project-'.$project->id, 'size' => 'sm'])
				@form(['method' => 'DELETE', 'url' => route('projects.destroy', $project), 'borderless' => true, 'data' => ['trigger' => 'loader']])
				<div>Are you sure?</div>
				<p class="text-red"><small>This action cannot be undone.</small></p>
				@submit(['label' => 'Yes, delete this project', 'theme' => 'red', 'classes' => 'btn-block'])
				@endform
			@endmodal
			@endif
		</div>
	</div>

	<div class="col-6">
		@include('pages.projects.familytree.tree')
	</div>
</div>
@endcontainer
@endsection

@push('scripts')
@endpush