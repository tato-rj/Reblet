<div class="d-flex justify-content-end">
	<a href="{{route('projects.team.show', $project)}}">
		<div class="d-flex align-items-center border rounded-pill p-2">
			<div class="text-muted mx-2"><strong><small>{{$project->name}}'s team</small></strong></div>
			<div class="d-flex justify-content-end" id="team-members"> 
				@foreach($project->team->orderedMembers() as $member)
				@include('pages.projects.team.member')
				@endforeach
			</div>
		</div>
	</a>
</div>