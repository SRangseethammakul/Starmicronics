<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Starmicronics | Dashboard</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport"
        content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" integrity="sha512-+4zCK9k+qNFUR5X+cKL9EIR+ZOhtIloNl9GIKS57V1MyNsYpYcUrUeQc9vNfzsWfV28IaLL3i96P9sdNyeRssA==" crossorigin="anonymous" />
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    @yield('contentcss')

    {{-- This page and all of the switch buttons shown are running on Bootstrap 4.3 --}}
    {{-- <link rel="stylesheet" href="/css/bootstrap4-toggle-3.6.1/bootstrap4-toggle.css"> --}}

</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom">
            <!-- Left navbar links -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" data-widget="pushmenu" href="#"><i class="fa fa-bars"></i></a>
                </li>
            </ul>
                <ul class="navbar-nav ml-auto">
                    <!-- Authentication Links -->
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button"
                            data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            <i class="far fa-user-circle"></i> {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                        document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>

            <!-- Right navbar links -->

        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" class="main-logo-app">
                <p class="brand-text font-weight-light">STAR MICRONICS SOUTHEAST ASIA</p>
            </a>
            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar user panel (optional) -->
                <!-- <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="info-user">
                    <span class="icon-user"> <i class="far fa-user-circle"></i> </span><a href="{{ route('dashboard.index')}}" class="d-block"><p> {{auth()->user()->name}}</p></a>
                    </div>
                </div> -->

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i> <p>Dashboard </p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.showData')}}" class="nav-link">
                                <i class="nav-icon fas fa-table"></i> <p>Data Table </p></a>
                        </li>
                        @role('Admin|Staff')
                        {{--
                        <li class="nav-item">
                            <a href="{{ route('export.excel')}}" class="nav-link">
                                <i class="nav-icon fas fa-file-excel"></i> <p>Import Excel</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('file-export')}}" class="nav-link">
                                <i class="nav-icon fas fa-file-excel"></i> <p>Export Excel</p></a>
                        </li>
                        --}}
                        @endrole
                        @role('Admin')
                        <li class="nav-item">
                            <a href="{{ route('usermanagement.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i> <p>User Managment</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('role.index')}}" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i> <p>Role</p></a>
                        </li>
                        @endrole
                    </ul>
                </nav>

                <!-- /.sidebar-menu -->
            </div>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->

            <!-- /.content-header -->
            @yield('content')
            <!-- Main content -->

            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">
            <strong>Star Micronics Southeast Asia Co., Ltd.</strong> All rights reserved.
            <div class="float-right d-none d-sm-inline-block">
                <a href="https://www.starmicronics.co.th/" target="blank"> <b><i class="fas fa-globe"></i> Enter website</b></a>
            </div>
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->



    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js')}}"></script>
    <script src="{{ asset('js/jquery-ui.min.js')}}"></script>
    <script src="{{ asset('js/Chart.min.js')}}"></script>
    @yield('footerscript')

</body>

</html>
