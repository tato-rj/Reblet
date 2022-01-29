<section>
  @component('layouts.navbar.horizontal', [
    'layout' => 'fixed',
    'classes' => 'border-bottom',
    'background' => 'white',
    'menu' => [
      'position' => 'end',    
    ],
  ])

  @isset($project)
  <div id="comments-notification" data-url="{{route('comments.index')}}" class="position-relative">
    @include('layouts.navbar.items.simple', ['icon' => 'envelope', 'height' => 4, 'gap' => 3])

    @include('layouts.navbar.items.comments-notification')
  </div>
  @endisset

  @include('layouts.navbar.items.logout', ['height' => 4, 'gap' => 3])

  @endcomponent
</section>