<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="loading">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title')</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/vendors.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-extended.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/colors.css') }}" rel="stylesheet">
    <link href="{{ asset('css/components.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vertical-menu.min.css') }}" rel="stylesheet">
    <link href="{{asset('css/toastr.css')}}" rel="stylesheet">

    
    @yield('css')

    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
</head>
<body class="vertical-layout vertical-menu-modern boxicon-layout no-card-shadow 2-columns  navbar-sticky footer-static menu-collapsed " data-open="click" data-menu="vertical-menu-modern" data-col="2-columns">
    <!-- BEGIN: Header-->
    <div class="header-navbar-shadow"></div>
    <nav class="header-navbar main-header-navbar navbar-expand-lg navbar navbar-with-menu fixed-top ">
        <div class="navbar-wrapper">
            <div class="navbar-container content">
                <div class="navbar-collapse" id="navbar-mobile">
                    <div class="mr-auto float-left bookmark-wrapper d-flex align-items-center">
                        <ul class="nav navbar-nav">
                            <li class="nav-item mobile-menu d-xl-none mr-auto"><a class="nav-link nav-menu-main menu-toggle hidden-xs" href="#"><i class="ficon bx bx-menu"></i></a></li>
                        </ul>
                    </div>
                    <ul class="nav navbar-nav float-right">
                        <li class="dropdown dropdown-user nav-item"><a class="dropdown-toggle nav-link dropdown-user-link" href="#" data-toggle="dropdown">
                                <div class="user-nav d-sm-flex d-none">
                                    <span class="user-name">{{Auth::user()->name}}</span>
                                </div><span>
                                    {{-- <img class="round" src="../../../app-assets/images/portrait/small/avatar-s-11.jpg" alt="avatar" height="40" width="40"> --}}
                                </span>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right">
                                <form action="{{route('logout')}}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item"><i class="bx bx-power-off mr-50"></i> Logout</button>
                                </form>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>
    <!-- END: Header-->

    <!-- BEGIN: Main Menu-->
    <div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
        <div class="navbar-header">
            <ul class="nav navbar-nav flex-row">
                <li class="nav-item mr-auto"><a class="navbar-brand" href="{{route('home')}}">
                        <div class="brand-logo"></div>
                        <h2 class="brand-text mb-0">Techno</h2>
                    </a></li>
                <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pr-0" data-toggle="collapse"><i class="bx bx-x d-block d-xl-none font-medium-4 primary toggle-icon"></i><i class="toggle-icon bx bx-disc font-medium-4 d-none d-xl-block collapse-toggle-icon primary" data-ticon="bx-disc"></i></a></li>
            </ul>
        </div>
        <div class="shadow-bottom"></div>
        <div class="main-menu-content">
            <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation" data-icon-style="">
                <li class="{{ (request()->is('home*')) ? 'active':'' }} nav-item"><a href="{{route('home')}}"><i class="bx bx-home-alt"></i><span class="menu-title" data-i18n="Dashboard">Dashboard</span></a>
                </li>
                <li class=" navigation-header"><span>Apps</span>
                </li>
                <li class="{{ (request()->is('job*')) ? 'active':'' }} nav-item"><a href="{{route('job.index')}}"><i class="bx bx-envelope"></i><span class="menu-title" data-i18n="Email">Jobs</span></a>
                </li>
                <li class="{{ (request()->is('notes*')) ? 'active':'' }} nav-item"><a href="{{route('notes.index')}}"><i class="bx bx-check-circle"></i><span class="menu-title" data-i18n="Notes">Notes</span></a>
                </li>
                <li class="{{ (request()->is('recrut*')) ? 'active':'' }} nav-item"><a href="{{route('recrut.index')}}"><i class="bx bx-calendar"></i><span class="menu-title" data-i18n="Calendar">Recruting</span></a>
                </li>
                @can('create-hr')
                    <li class="{{ (request()->is('hr*')) ? 'active':'' }} nav-item"><a href="{{route('hr.index')}}"><i class="bx bx-user-plus"></i><span class="menu-title" data-i18n="Kanban">HR</span></a>
                    </li>
                @endcan
            </ul>
        </div>
    </div>
    <!-- END: Main Menu-->


    <div class="app-content content">
        <div class="content-overlay"></div>
        <div class="content-wrapper">
            <div class="content-header row">
            </div>
            <div class="content-body">
                <!-- Basic Kanban App -->
                <div class="kanban-overlay"></div>
                <section id="kanban-wrapper">

                    @yield('content')

                </section>
                <!--/ Sample Project kanban -->

            </div>
        </div>
    </div>



    <div class="sidenav-overlay"></div>
    <div class="drag-target"></div>

     <!-- BEGIN: Footer-->
     <footer class="footer footer-static footer-light">
        <p class="clearfix mb-0"><span class="float-left d-inline-block">2021 &copy; techno stacks</span><span class="float-right d-sm-inline-block d-none">Devloped By  :  <a class="text-uppercase" href="https://1.envato.market/pixinvent_portfolio" target="_blank">Jeet & Mayank</a></span>
            {{-- <button class="btn btn-primary btn-icon scroll-top" type="button"><i class="bx bx-up-arrow-alt"></i></button> --}}
        </p>
    </footer>
    <!-- END: Footer-->

    <script src="{{asset('js/vendors.min.js')}}"></script>
    <script src="{{asset('js/quill.min.js')}}"></script>
    <script src="{{asset('js/app-menu.min.js')}}"></script>
    <script src="{{asset('js/app.js')}}"></script>
    <script src="{{asset('js/toastr.min.js')}}"></script>
    @yield('js')
</body>
</html>
