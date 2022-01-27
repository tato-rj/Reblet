@php($navId = 'navbar-'.uuid())

<div class="navbar-{{$layout ?? null}} w-100" id="navbar-horizontal">
  <nav class="navbar navbar-horizontal {{isset($menu['offcanvas']) ? null : 'navbar-expand-lg'}} py-0 px-2 navbar-light bg-{{$background ?? null}} {{$classes ?? null}}">
    <div class="container-fluid">
      @include('layouts.components.logo')
      @include('layouts.navbar.items.hamburger', ['navId' => $navId, 'offcanvas' => isset($menu['offcanvas'])])
      
      @isset($menu['offcanvas'])
      @include('layouts.navbar.items.offcanvas', compact('navId'))
      @else
      <div class="collapse navbar-collapse justify-content-{{$menu['position'] ?? 'end'}}" id="{{$navId}}">
        <ul class="navbar-nav">
          @foreach($menu['items'] as $item)
          @if(isset($item['dropdown']))
          @include('layouts.navbar.items.dropdown', $item)
          @elseif(isset($item['panels']))
          @include('layouts.navbar.items.panels', $item)
          @elseif(isset($item['logout']))
          @include('layouts.navbar.items.logout')
          @else
          @include('layouts.navbar.items.simple', $item)
          @endif
          @endforeach
        </ul>
      </div>
      @endisset
    </div>
  </nav>
</div>