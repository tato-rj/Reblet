<section>
  @include('layouts.navbar.horizontal', [
    'layout' => 'fixed',
    'classes' => 'border-bottom',
    'background' => 'white',
    'menu' => [
      'position' => 'end',
      'gap' => 3,
      'height' => 4,
      'hover' => 'background',
      'background' => 'blue',
      'items' => [
        ['logout' => true]
      ]
    ],
  ])
</section>