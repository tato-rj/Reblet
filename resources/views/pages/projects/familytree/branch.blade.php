@if($child->children->count() > 0)
<ul>
	@foreach($child->children as $child)
	<li><a href="{{$child->route()}}"><code class="alert-grey border px-2 py-1 rounded text-nowrap">@fa(['icon' => 'folder']){{$child->name}}</code></a>
		@include('pages.projects.familytree.branch')
	</li>
	@endforeach
</ul>
@endif