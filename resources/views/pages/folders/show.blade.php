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
class DragDrop
{
	constructor(params)
	{
		this.formId = params.formId;
		this.method = params.method;
		this.maxFilesize = params.maxFilesize;
		this.parallelUploads = params.parallelUploads;
		this.thumbPath = params.thumbPath;
	}

	run()
	{
		let obj = this;
		
		Dropzone.autoDiscover = false;

		let dropzone = new Dropzone(obj.formId, {
			method: obj.method,
			url: '#',
			maxFilesize: obj.maxFilesize, // MB
			parallelUploads: obj.parallelUploads,
			dictDefaultMessage: '',
		    headers: {},
		    accept: function(file, next) {
		    	obj._checkForDuplicate(file)
		    		.then(function(response) {
		    			let fileExists = response.data;
			    		if (! fileExists || confirm('This file already exists. Do you want to replace it?')) {
			    			obj._uploadFile(file, next);
			    		} else {
			    			dropzone.removeFile(file);
			    		}
		    		});
		    },
		    sending: function(file, xhr) {
		        var _send = xhr.send;
		        xhr.setRequestHeader('x-amz-acl', 'public-read');
		        xhr.send = function() {
		            _send.call(xhr, file);
		        }
		    },
		    processing: function(file) {
		        this.options.url = file.signedRequest;
		        log(file.signedRequest);
		    },
			init: function() {
				this.on('addedfile', file => {
					obj._getIcon(file, this);
				});
				// this.on("sending", file => {});
				// this.on("error", (file, error) => {});
				this.on("success", (file) => {
					obj._saveFile(file);
				});
				// this.on("complete", (file) => {});
				// this.on('thumbnail', (file, thumbnail) => {})
			},
			error: function(file, error) {
				log('ERROR: '+error);
			}
		});

		return obj;
	}

	_getPresignedUrl(file)
	{
		let params = {
			path: $(this.formId).data('path'),
			name: file.name
		};

		return axios.post($(this.formId).attr('presignedUrl'), params);
	}

	_checkForDuplicate(file)
	{
		return axios.get($(this.formId).attr('checkFile'), {params: {name: file.name}})
	}

	_uploadFile(file, next)
	{
		let obj = this;

    	obj._getPresignedUrl(file)
    	 .then(function(response) {
    	 	file.data = {
    	 		path: response.data.path, 
    	 		name: response.data.name,
    	 		originalName: file.name,
    	 		type: file.type, 
    	 		size: file.size,
    	 		given_name: file.name.split('.').shift()
    	 	};

    	 	file.signedRequest = response.data.url;
    	 	next();
    	 })
    	 .catch(function(error) { next('Could not get the presigned url.'); });
	}

	_saveFile(file)
	{
		let $form = $(this.formId);

		axios.post($form.attr('saveFile'), file.data)
			.then(function(response) {
			 	$('.revision-tab.active .files-container').html(response.data);
			});
	}

	_getIcon(file, dropzone)
	{
		let extensions = ['pdf', 'doc', 'docx', 'dwg', 'ai', 'afdesign'];
		let file_ext = file.name.split('.').pop();
		let file_type = file.type.split('/').shift();
		let thumbnail;

		if (file_type == 'image') {
			thumbnail = file.url;
		} else if (extensions.includes(file_ext)) {
			thumbnail = this.thumbPath + file_ext + ".svg";
		} else {
			thumbnail = this.thumbPath + "default.svg";
		}

		if (typeof thumbnail != 'undefined')
			dropzone.emit('thumbnail', file, thumbnail);
	}
}

window.DragDrop = DragDrop;
</script>

<script type="text/javascript">
let dragdrop;

$('#revisions-tab [data-bs-toggle="tab"]').on('show.bs.tab', function(event) {
	let $tab = $(event.target);
	axios.get($tab.data('dropzone'))
		 .then(function(response) {
		 	$('.dropzone-container').remove();
		 	$($tab.attr('href')).prepend(response.data);
		 	newDropzone();
		 })
		 .catch(function(error) {
		 	console.log(error);
		 });
});

newDropzone();

function newDropzone()
{
	let formId = '#'+$('.dropzone').attr('id');

	dragdrop = new DragDrop({
		formId: formId,
		thumbPath: '/images/file_icons/',
		method: 'PUT',
		maxFilesize: 1000,
		parallelUploads: 4,
	}).run();
}
</script>

<script type="text/javascript">
$('#file-panel').on('file-panel:open', function(event) {
	if (! $(this).is(':visible'))
		$(this).animate({width: 'toggle'}, 150);

	let $comments = $('.comments-container');

	if ($comments.length) {
		axios.patch($comments.data('read-url'))
			 .then(function(response) {
			 	//
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
$(document).on('keyup', 'form.chat-form textarea[name="content"]', function() {
	if ($(this).val().length > 2) {
		window.Echo.private(project.channels.comments).whisper('typing', {
	        name: user.name
	    });
	} else {
		window.Echo.private(project.channels.comments).whisper('typing', {
	        name: null
	    });	
	}
});

Echo.private(project.channels.comments)
    .listenForWhisper('typing', (e) => {
        if ($('#typing').length && e.name) {
        	$('#typer').text(e.name + ' is typing');
        	$('#typing').show();
        } else {
        	$('#typing').hide();
        	$('#typer').text('');
        }
    });
</script>

<script type="text/javascript">
// AUTO OPEN COMMENTS TAB
$(document).ready(function() {
	$('button[data-action="'+unreadComments+'"]').click();
});
</script>
@endpush