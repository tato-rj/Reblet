          <div class="w-100 h-100 overlay-darkest panel-overlay position-fixed" style="top: 0; left: 0; display: none" id="menu-overlay"></div>
          <div class="navbar-mobile menu-mobile-hidden" id="menu-mobile">
            <ul class="navbar-nav flex-column menu p-5">
              <div class="d-flex justify-content-end cursor-pointer" id="menu-close">@fa(['icon' => 'times'])</div>
              <li class="nav-item dropdown border-bottom py-2">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                  SERVICES
                </a>
                <div class="dropdown-menu border-0 rounded-0" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item py-2 text-wrap" href="{{route('control')}}">Control System Conversion</a>
                  <a class="dropdown-item py-2 text-wrap" href="{{route('purchasing')}}">Hoist & Components Purchasing</a>
                  <a class="dropdown-item py-2 text-wrap" href="{{route('contact')}}">Construction Hoist Rental</a>
                  <a class="dropdown-item py-2 text-wrap" href="{{route('contact')}}">Installation & Modernization</a>
                </div>
              </li>

              <li class="nav-item dropdown border-bottom py-2">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                  INDUSTRIES
                </a>
                <div class="dropdown-menu border-0 rounded-0" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item py-2 text-wrap" href="{{route('gc')}}">General Contractors</a>
                  <a class="dropdown-item py-2 text-wrap" href="{{route('hc')}}">Hoisting Companies</a>
                </div>
              </li>
              <li class="nav-item py-2 border-bottom">
                <a class="nav-link" href="{{route('about')}}">ABOUT US</a>
              </li>
              <li class="nav-item py-2 mb-3">
                <a class="nav-link" href="{{route('contact')}}">CONTACT</a>
              </li>
              <li class="nav-item">
                  <div style="font-size: 14px">@fa(['icon' => 'phone-alt']) {{config('brand.phone')}}</div>
                  <div class="mb-3" style="font-size: 14px">@fa(['icon' => 'envelope']) {{config('brand.emails.info')}}</div>
                  <a href="" id="menubtn" class="btn btn-wide btn-outline-primary">@fa(['icon' =>'plus'])SCHEDULE MEETING</a>
              </li>
            </ul>
          </div>