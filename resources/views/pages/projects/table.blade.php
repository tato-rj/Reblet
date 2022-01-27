<table class="table table-hover table-responsive">
  <thead>
    <tr>
      <th scope="col">Project</th>
      <th scope="col">Status</th>
      <th scope="col">Date</th>
    </tr>
  </thead>
  <tbody>
  	@foreach(auth()->user()->teams->pluck('project') as $project)
    <tr>
      <td class="align-baseline">
        <a href="{{route('projects.show', $project)}}">{!! $project->creator->avatar() !!}{{$project->name}}</a>
      </td>

      <td class="align-baseline">
        @if($project->team->leader()->is(auth()->user()))
        @fa(['icon' => 'star', 'fa_color' => 'yellow'])Leader
        @else
        @fa(['icon' => 'user', 'fa_color' => 'stone'])Member
        @endif
      </td>

      <td class="align-baseline">{{$project->created_at->toFormattedDateString()}}</td>
    </tr>
    @endforeach
  </tbody>
</table>