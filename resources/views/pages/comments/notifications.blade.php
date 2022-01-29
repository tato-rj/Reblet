	@foreach($comments as $comment)
	<div class="d-apart {{$loop->last ? null : 'border-bottom'}}" style="width: 340px">
		<div class="py-2 px-3" style="max-width: 76%">
			@include('pages.comments.components.user')
			<div class="text-truncate"><strong><small>{{$comment->model->publicName(true)}}</small></strong></div>
		</div>
		<div class="bg-light p-3">
			@btn(['url' => $comment->model->route(['panel' => 'comments-'.$comment->model->id]),'label' => 'Read', 'theme' => 'outline-primary', 'classes' => 'btn-sm'])
		</div>
	</div>	
	@endforeach