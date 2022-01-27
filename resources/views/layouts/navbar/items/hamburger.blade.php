@hamburger([
  'type' => 'elastic',
  'py' => $menu['height'] ?? null,
  'px' => $menu['gap'] ?? null,
  'toggle' => $offcanvas ? 'offcanvas' : 'collapse',
  'target' => $navId
])