@component('pages.files.panel.layout', ['title' => 'Supporting documents', 'id' => 'supporting-docs', 'file' => $file])

<div class="bg-light rounded p-3 mb-4">
	@forelse($file->supportData as $supportFile)
	@if($supportFile->type == 'url')
	<div class="cursor-pointer text-nowrap {{! $loop->last ? 'mb-2 pb-2 border-bottom' : null}}" 
	data-bs-toggle="tooltip" 
	data-bs-trigger="manual"
	data-dynamic-clipboard-text="{{$supportFile->url}}"
	>@fa(['icon' => 'copy', 'fa_type' => 'r']){{$supportFile->url}}</div>
	@else
	<div class="{{! $loop->last ? 'mb-2 pb-2 border-bottom' : null}}">{{$supportFile->data}}</div>
	@endif
	@empty
	<div class="text-center text-muted">
		<i>No support data added yet...</i>
	</div>
	@endforelse
</div>

@btn(['icon' => ['name' => 'plus', 'position' => 'left'], 'label' => 'Add new file', 'theme' => 'primary', 'modal' => 'support-file-modal', 'classes' => 'mx-auto'])
@modal(['title' => 'Add support file', 'id' => 'support-file-modal'])
	@form(['method' => 'POST', 'url' => route('files.support-data.store', $file), 'classes' => 'support-data-form'])
		@select(['name' => 'type', 'label' => 'Type of document', 'required' => true, 'placeholder' => 'Select'])
		@option(['value' => 'url', 'label' => 'Link'])
		@option(['value' => 'data', 'label' => 'Text'])
		@endselect

		<div class="url hidden-inputs" style="display: none;"> 
			@input(['name' => 'url', 'label' => 'Url'])
		</div>
		<div class="data hidden-inputs" style="display: none"> 
			@input(['name' => 'data', 'label' => 'Text'])
		</div>

		@submit(['label' => 'Save', 'theme' => 'primary'])
	@endform
@endmodal
@endcomponent