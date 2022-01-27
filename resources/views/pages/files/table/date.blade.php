@if($file->replaced_at)
<span class="text-green">{{$file->replaced_at->diffForHumans()}}</span>
@else
<span class="text-warning">@fa(['icon' => 'exclamation-circle'])New file</span>
@endif