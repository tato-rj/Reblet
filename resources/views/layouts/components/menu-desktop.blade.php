          <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto menu">

              <li class="nav-item dropdown px-3">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                  SERVICES
                </a>
                <div class="dropdown-menu border-0 rounded-0" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item py-2" href="{{route('control')}}">Control System Conversion</a>
                  <a class="dropdown-item py-2" href="{{route('purchasing')}}">Hoist & Components Purchasing</a>
                  <a class="dropdown-item py-2" href="{{route('contact')}}">Construction Hoist Rental</a>
                  <a class="dropdown-item py-2" href="{{route('contact')}}">Installation & Modernization</a>
                </div>
              </li>

              <li class="nav-item dropdown px-3">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button" data-toggle="dropdown" aria-expanded="false">
                  INDUSTRIES
                </a>
                <div class="dropdown-menu border-0 rounded-0" aria-labelledby="navbarDropdownMenuLink">
                  <a class="dropdown-item py-2" href="{{route('gc')}}">General Contractors</a>
                  <a class="dropdown-item py-2" href="{{route('hc')}}">Hoisting Companies</a>
                </div>
              </li>

              <li class="nav-item px-3">
                <a class="nav-link" href="{{route('about')}}">ABOUT US</a>
              </li>
              <li class="nav-item px-3">
                <a class="nav-link" href="{{route('contact')}}">CONTACT</a>
              </li>
              <li class="nav-item pl-3">
                  <a href="{{config('brand.calendly')}}" target="_blank" id="menubtn" class="btn btn-wide btn-white">@fa(['icon' =>'plus'])SCHEDULE MEETING</a>
              </li>
            </ul>
          </div>