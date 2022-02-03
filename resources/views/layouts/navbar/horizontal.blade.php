@php($navId = 'navbar-'.uuid())

<div class="navbar-{{$layout ?? null}} w-100" id="navbar-horizontal">
  <nav class="navbar navbar-horizontal navbar-expand-lg py-0 px-2 navbar-light bg-{{$background ?? null}} {{$classes ?? null}}">
    <div class="container-fluid">
      @include('layouts.components.logo')
      @include('layouts.navbar.items.hamburger', ['navId' => $navId, 'offcanvas' => isset($offcanvas)])
      
      @isset($offcanvas)
      @include('layouts.navbar.items.offcanvas', compact('navId'))
      @else
      <div class="collapse navbar-collapse justify-content-{{$position ?? 'end'}}" id="{{$navId}}">
        <ul class="navbar-nav">

          {{$slot}}

        </ul>
      </div>
      @endisset
    </div>
  </nav>
</div>