<head>
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
</head>
<body id="page-top">
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar" style="position: fixed">

                <!-- Sidebar - Brand -->
                <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                  <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                  </div>
                  <div class="sidebar-brand-text mx-3">SB Admin <sup>2</sup></div>
                </a>

                <!-- Divider -->
                <hr class="sidebar-divider my-0">

                <!-- Nav Item - Dashboard -->
                <li class="nav-item active">
                  <a class="nav-link" href="index.html">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span></a>
                </li>

                <!-- Divider -->
                <hr class="sidebar-divider">


                <!-- Heading -->
                <div class="sidebar-heading">
                  Data
                </div>

                <!-- Nav Item - Charts -->
                <li class="nav-item">
                  <a class="nav-link" href="{{route('items.index')}}">
                    <i class="fas fa-fw fa-chart-area"></i>
                    <span>Items</span></a>
                </li>

                <!-- Nav Item - Tables -->
                <li class="nav-item">
                  <a class="nav-link" href="{{route('categories.index')}}">
                    <i class="fas fa-fw fa-table"></i>
                    <span>Categories</span></a>
                </li>

                <li class="nav-item">
                        <a class="nav-link" href="{{route('transactions.index')}}">
                          <i class="fas fa-fw fa-table"></i>
                          <span>Transaction</span></a>
                      </li>

                <li class="nav-item">
                                <a class="nav-link" href="{{ route('logout') }}"
                                   onclick="event.preventDefault();
                                                 document.getElementById('logout-form').submit();">
                                    {{ __('Logout') }}
                                </a>

                                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                    @csrf
                                </form>

                </li>
                <!-- Divider -->
                <hr class="sidebar-divider d-none d-md-block">

                <!-- Sidebar Toggler (Sidebar) -->
                <div class="text-center d-none d-md-inline">
                  <button class="rounded-circle border-0" id="sidebarToggle"></button>
                </div>

              </ul>

              @yield('content')
</body>
<!-- <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script> -->
<script src="{{asset('jquery/jquery-3.4.1.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
