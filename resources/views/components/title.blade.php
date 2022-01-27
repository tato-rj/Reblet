<div class="mb-4">
	<h3 class="m-0">
		@isset($icon)
		@fa(['icon' => $icon['name'], 'fa_color' => $icon['color'] ?? null])
		@endisset{{$title}}
	</h3>
	@isset($subtitle)
	<p class="text-muted"><small>{{$subtitle}}</small></p>
	@endisset
	@isset($description)
	<p class="text-muted m-0">{{$description}}</p>
	@endisset
</div>