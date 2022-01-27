<div class="panel-action" data-action="{{$id}}-{{$file->id}}">
	<div class="position-relative pl-4 mb-4 d-apart panel-title">
		<div>
			<h5 class=" text-nowrap mb-0">{{$title}}</h5>
			<div class="text-muted"><small>{{$file->publicName()}}</small></div>
		</div>
		<button type="button" class="btn-close" data-dismiss="panel" aria-label="Close"></button>
	</div>
	<div class="pl-4">
		{{$slot}}
	</div>
</div>