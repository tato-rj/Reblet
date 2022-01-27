<table class="table table-hover table-responsive">
  <thead>
    <tr>
      <th scope="col">Member</th>
      <th scope="col" class="text-right">Since</th>
      <th scope="col" class="text-right">Actions</th>
    </tr>
  </thead>
  <tbody>
  	@foreach($team->members as $member)
    <tr>
      <td class="align-baseline">{!! $member->avatar() !!}{{$member->name}}
        @if($team->leader()->is($member))
        @fa(['icon' => 'star', 'fa_color' => 'yellow', 'mr' => 0, 'ml' => 1])
        @endif
      </td>

      <td class="text-right align-baseline">{{$member->pivot->created_at->toFormattedDateString()}}</td>

      <td class="align-baseline ">
        <div class="d-flex justify-content-end align-items-center">
          <div class="mr-2 opacity-6" data-toggle="tooltip" data-bs-placement="top" title="Send an email">
            @btn(['icon' => ['name' => 'envelope', 'position' => 'center'], 'theme' => 'raw'])
          </div>

          @if(auth()->user()->can('update', $team))
          @delete(['item' => 'member', 'target' => 'remove-member-'.$member->id, 'url' => route('projects.team.remove', ['project' => $team->project, 'email' => $member->email])])
          @endif
        </div>
      </td>
    </tr>
    @endforeach
  </tbody>
</table>