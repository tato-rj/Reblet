<div>
	<a href="{{route('files.download', $file)}}" class="">{!! $file->creator->avatar() !!}<span>{{$file->publicName(true)}}</span></a>
	@if($file->unused())
	<span class="ml-2 badge alert-orange">@fa(['icon' => 'exclamation-circle'])unchanged</span>
	@endif
</div>