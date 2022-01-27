<table class="table table-hover table-responsive">
  <thead>
    <tr>
      <th scope="col">Folder</th>
      <th scope="col" class="text-right">Date</th>
      <th scope="col" class="text-right">Actions</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($folder->children as $child)
    <tr>
      <td><a href="{{$child->route()}}">{!! $child->creator->avatar() !!}@fa(['icon' => 'folder', 'fa_size' => 'lg', 'fa_color' => 'primary']){{$child->name}}</a></td>

      <td class="text-right align-baseline">{{$child->created_at->toFormattedDateString()}}</td>

      <td class="align-baseline">
        <div class="d-flex justify-content-end">
          <div  data-bs-toggle="tooltip" 
                data-bs-trigger="manual"
                data-clipboard-text="{{$child->route()}}">
            @fa(['icon' => 'link', 'theme' => 'primary'])
          </div>
          @delete(['item' => 'folder', 'target' => 'folder-'.$child->id, 'url' => route('projects.folders.destroy', ['project' => $project, 'folder' => $child])])
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>
{{-- 
<div class="mb-4 mr-4 d-inline-block">
	<a href="{{route('projects.folders.show', ['project' => $project, 'folder' => $child])}}">
		<div class="mb-0">
			@fa(['icon' => 'folder', 'fa_size' => '5x', 'fa_color' => 'primary', 'mr' => 0])
		</div>
		<div>{{$child->name}}</div>
	</a>
</div> --}}