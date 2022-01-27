<div class="mb-3">
	<div class="d-flex align-items-center ml-2 mb-1">
		{!!$comment->user->avatar('xs')!!}
		<div class="text-muted" style="font-size: 72%"><strong>{{$comment->user->name}}</strong></div>
	</div>
	<div class="rounded {{$comment->user->is(auth()->user()) ? 'border' : 'bg-blue-lighter'}} px-3 py-2">
		<div class="d-apart">
			<div class="text-muted" style="font-size: 72%">{{$comment->date}}</div>
			@if($comment->user->is(auth()->user()))
			<div>@delete(['item' => 'comment', 'target' => 'comment-'.$comment->id, 'url' => route('comments.destroy', $comment), 'size' => 'sm', 'color' => 'grey'])</div>
			@endif
		</div>
		<div>
			{{$comment->content}}
		</div>
	</div>
</div>