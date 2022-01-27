@component('pages.files.panel.layout', ['title' => 'Info', 'id' => 'info', 'file' => $file])
<div class="mb-3">
	@label(['label' => 'Original file'])
	<div>{{$file->given_name}}.{{$file->extension}}</div>
</div>

<div class="mb-3">
	@label(['label' => 'Description'])
	@if($file->description)
	<div>{{$file->description}}</div>
	@else
	<div class="text-warning">@fa(['icon' => 'exclamation-circle'])No description yet</div>
	@endif
</div>

<div class="mb-3">
	@label(['label' => 'Uploaded by'])
	<div>{{$file->creator->name}}</div>
</div>

<div class="mb-3">
	@label(['label' => 'Created at'])
	<div>{{$file->created_at->toDayDateTimeString()}}</div>
</div>

<div class="mb-3">
	@label(['label' => 'Last updated'])
	<div>@include('pages.files.table.date')</div>
</div>

<div class="mb-3">
	@label(['label' => 'Last downloaded'])
	<div>{{$file->downloaded_at ? $file->downloaded_at->diffForHumans() : 'This file hasn\'t been downloaded yet'}}</div>
</div>

<div class="mb-3">
	@label(['label' => 'Status'])
	<div>
		@if($file->duplicatedFrom()->exists())
		This file was duplicated from {{$file->duplicatedFrom->formattedName}}
		@else
		This file is new to the project
		@endif
	</div>

</div>
@endcomponent