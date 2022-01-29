<div class="mb-3 comment">
	@include('pages.comments.components.user')
	<div class="rounded {{$comment->user->is(auth()->user()) ? 'border' : 'bg-blue-lighter'}} px-3 py-2">
		<div class="d-apart">
			<div class="text-muted" style="font-size: 72%">{{$comment->date}}</div>
			@if($comment->user->is(auth()->user()))
			<div>
				@delete(['item' => 'comment', 'target' => 'delete-comment-'.$comment->id.'-modal', 'url' => route('comments.destroy', $comment), 'size' => 'sm', 'color' => 'grey'])
			</div>
			@endif
		</div>
		<div>
			{{$comment->content}}
		</div>
	</div>
</div>