  <ul class="tree mx-auto">
    <li><code class="border border-primary p-3 text-primary rounded">Project Folders</code>
    {{-- <li><code class="border border-primary p-3 text-primary rounded">{{$project->name}}</code> --}}
      <ul>
      	@foreach($project->folders as $child)
      	<li><a href="{{$child->route()}}"><code class="alert-grey border px-2 py-1 rounded text-nowrap">@fa(['icon' => 'folder']){{$child->public_name ?? $child->name}}</a></code>
      		@include('pages.projects.familytree.branch')
      	</li>
      	@endforeach
      </ul>
    </li>
  </ul>