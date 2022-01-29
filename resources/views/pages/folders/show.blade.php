@extends('layouts.app', ['title' => $project->name . ' - ' .  $folder->name])

@push('header')
<link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />
<style type="text/css">
#folder-panel {
	position: absolute;
	top: 0;
	right: 0;
}

.dropzone {
	min-height: auto;
	border:  4px dashed lightgrey;
}

.dropzone .dz-message {
	font-weight: bold;
	color: grey;
}

#file-panel {
	display: none;
	width: 400px;
}

#team-members > div:not(:first-of-type) {
	margin-left: -22px;
}

</style>

@endpush

@section('content')
<div class="d-flex">
	<div class="flex-grow-1"> 
	@container(['marginTop' => 0])
		@include('pages.projects.team.show')

		@breadcrumb(['trail' => $folder->breadcrumb(), 'current' => $folder->name])

		<div class="mb-4">
			<h3 class="m-0">@fa(['icon' => 'folder-open', 'fa_color' => 'muted']){{$folder->name}}</h3>
			<p class="text-muted"><small>Created by {{$folder->creator->name}}</small></p>
			<p class="text-muted">{{$folder->description}}</p>
		</div>

		<div class="mb-2 position-relative"> 
			@if($folder->children()->exists())
				@include('pages.folders.components.table')
			@else
				@include('pages.revisions.show')
			@endif
		</div>
		
		<div>
			@include('pages.folders.create')
		</div>
	@endcontainer
	</div>


	@include('pages.files.panel')
</div>

@include('pages.files.create')

@endsection

@push('scripts')
<script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
<script type="text/javascript" src="{{mix('js/dragdrop.js')}}"></script>

<script type="text/javascript">
$('#file-panel').on('file-panel:open', function(event) {
	if (! $(this).is(':visible'))
		$(this).animate({width: 'toggle'}, 150);

	let $comments = $('.comments-container');

	if ($comments.length) {
		axios.patch($comments.data('read-url'))
			 .then(function(response) {
			 	log(response.data);
			 })
			 .then(function() {
			 	alertUnreadComments();
			 });
	}
});

$('#file-panel').on('file-panel:close', function(event) {
	$(this).animate({width: 'toggle'}, 150, function() {
		$(this).html('');
	});
});
</script>

<script type="text/javascript">
$(document).on('submit', '[id^=delete-comment] form', function(e) {
	e.preventDefault();

	let $modal = $(this).closest('.modal');
	let $comment = $(this).closest('.comment');

	axios.delete($(this).attr('action'))
		 .then(function(response) {
		 	$modal.modal('hide');
		 	$modal.on('hidden.bs.modal', function() {
		 		$comment.remove();
		 	})
		 })
		 .catch(function(error) {
		 	log(error);
		 });
});
</script>

<script type="text/javascript">
// AUTO OPEN COMMENTS TAB
$(document).ready(function() {
	$('button[data-action="'+unreadComments+'"]').click();
});
</script>
@endpush