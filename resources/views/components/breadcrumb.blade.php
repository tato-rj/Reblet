<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    @foreach($trail as $model)
    <li class="breadcrumb-item"><a href="{{$model['url']}}">{{$model['name']}}</a></li>
    @endforeach
    <li class="breadcrumb-item active" aria-current="page">{{$current}}</li>
  </ol>
</nav>