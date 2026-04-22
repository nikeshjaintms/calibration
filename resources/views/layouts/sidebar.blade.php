<body>
    <div class="wrapper">
      <!-- Sidebar -->
      <div class="sidebar" data-background-color="dark">
        <div class="sidebar-logo">
          <!-- Logo Header -->
          <div class="logo-header" data-background-color="dark">
            <a href="{{ route('dashboard') }}" class="logo">
              <img src="{{ asset('logo/Automac white logo.png') }}" alt="navbar brand" class="navbar-brand" height="50">
            </a>
            <div class="nav-toggle">
              <button class="btn btn-toggle toggle-sidebar">
                <i class="gg-menu-right"></i>
              </button>
              <button class="btn btn-toggle sidenav-toggler">
                <i class="gg-menu-left"></i>
              </button>
            </div>
            <button class="topbar-toggler more">
              <i class="gg-more-vertical-alt"></i>
            </button>
          </div>
          <!-- End Logo Header -->
        </div>
        <div class="sidebar-wrapper scrollbar scrollbar-inner">
          <div class="sidebar-content">
            <ul class="nav nav-secondary">
              <li class="nav-item {{ request()->is('dashboard') ? 'active' : '' }}">
                <a href="{{ route('dashboard') }}">
                  <i class="fas fa-home"></i>
                  <p>Dashboard</p>
                </a>
              </li>
                 <li class="nav-item {{ request()->is('users*') ? 'active' : '' }}">
                <a href="{{ route('users.index') }}">
                  <i class="fas fa-user"></i>
                  <p>Users</p>
                </a>
              </li>
               <li class="nav-item {{ request()->is('flanges*') ? 'active' : '' }}">
                <a href="{{ route('flanges.index') }}">
                  <i class="fas fa-file-invoice"></i>
                  <p>Flanges</p>
                </a>
              </li>
               <li class="nav-item {{ request() }}">
                <a href="{{ route('mocs.index') }}">
                  <i class="fas fa-file-invoice"></i>
                  <p>MOC</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="{{ route('capillaries.index') }}">
                  <i class="fas fa-file-invoice"></i>
                  <p>Capillaries</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('jobcards.index') }}">
                  <i class="fas fa-file-invoice"></i>
                  <p>Jobcards</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('inspections.index') }}">
                  <i class="fas fa-clipboard-check"></i>
                  <p>Inspections</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('oil-fillings.index') }}">
                  <i class="fas fa-oil-can"></i>
                  <p>Oil Filling</p>
                </a>
              </li>
              <li class="nav-item">
                <a href="{{ route('calibrations.index') }}">
                  <i class="fas fa-balance-scale"></i>
                  <p>Calibration</p>
                </a>
              </li>              
            </ul>
          </div>
        </div>
      </div>
