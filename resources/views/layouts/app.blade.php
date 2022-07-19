<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard &mdash; E-Skul</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/school.svg') }}" type="image/x-icon">
    <!-- General CSS Files -->
    <link rel="stylesheet" href="{{ asset('assets/modules/bootstrap/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/modules/fontawesome/css/all.min.css') }}">

    <!-- CSS Libraries -->


    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/components.css') }}">


    <script src="{{ asset('assets/modules/jquery.min.js') }}"></script>
    <!-- <script src="{{ asset('assets/js/sweetalert.min.js') }}"></script> -->

    @yield('internalCSS')

</head>

<body style="background: #e2e8f0">
    <div id="app">
        <div class="main-wrapper main-wrapper-1">
            <div class="navbar-bg"></div>
            <nav class="navbar navbar-expand-lg main-navbar">
                <form class="form-inline mr-auto">
                    <ul class="navbar-nav mr-3">
                        <li><a href="#" data-toggle="sidebar" class="nav-link nav-link-lg"><i
                                    class="fas fa-bars"></i></a></li>
                    </ul>
                </form>
                <ul class="navbar-nav navbar-right">

                    <li class="dropdown"><a href="#" data-toggle="dropdown"
                            class="nav-link dropdown-toggle nav-link-lg nav-link-user">
                            <img alt="image" src="{{ asset('assets/img/avatar/avatar-1.png') }}"
                                class="rounded-circle mr-1">
                            <div class="d-sm-none d-lg-inline-block">Hi,
                                @if (Auth::user()->role->role == 'admin')
                                {{ __('Admin') }}
                                @elseif (Auth::user()->role->role == 'guru')
                                {{ Auth::user()->guru->nama }}
                                @else
                                {{ Auth::user()->siswa->nama }}
                                @endif
                            </div>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('logout') }}" style="cursor: pointer" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"
                                class="dropdown-item has-icon text-danger">
                                <i class="fas fa-sign-out-alt"></i> Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            <div class="main-sidebar sidebar-style-2">
                <aside id="sidebar-wrapper">
                    <div class="sidebar-brand">
                        <a href="index.html">E-Skul</a>
                    </div>
                    <div class="sidebar-brand sidebar-brand-sm">
                        <a href="index.html">ES</a>
                    </div>
                    <ul class="sidebar-menu">
                        <li class="menu-header">MAIN MENU</li>
                        <li class="{{ setActive('admin/home') }}"><a class="nav-link"
                                href="{{ route('admin.home') }}"><i class="fas fa-tachometer-alt"></i>
                                <span>Dashboard</span></a></li>
                        <li class="dropdown {{ setActive('master_')  }}">

                            <a href="#" class="nav-link has-dropdown"><i class="fas fa-users"></i><span>Master
                                    Data</span></a>

                            <ul class="dropdown-menu">

                                <li class="{{ setActive('master_guru') }}"><a class="nav-link"
                                        href="{{ route('master_guru.index') }}"><i class="fas fa-unlock"></i>Guru</a>
                                </li>
                                <li class="{{ setActive('master_mapel') }}"><a class="nav-link"
                                        href="{{ route('master_mapel.index') }}"><i class="fas fa-book"></i>Mata
                                        Pelajaran</a>
                                </li>
                                <li class="{{ setActive('master_siswa') }}"><a class="nav-link"
                                        href="{{ route('master_siswa.index') }}"><i
                                            class="fas fa-user-friends"></i>Siswa</a>
                                </li>
                                <li class="{{ setActive('master_kelas') }}"><a class="nav-link"
                                        href="{{ route('master_kelas.index') }}"><i
                                            class="fas fa-chalkboard-teacher"></i>Kelas</a>
                                </li>
                                <li class="{{ setActive('master_jadwal_pelajaran') }}"><a class="nav-link"
                                        href="{{ route('master_jadwal_pelajaran.index') }}"><i
                                            class="fas fa-calendar-alt"></i>Jadwal</a>
                                </li>


                                <!-- 
                                <li class="{{ setActive('admin/permission') }}"><a class="nav-link" href="#"><i
                                            class="fas fa-key"></i>
                                        Permissions</a></li>



                                <li class="{{ setActive('admin/user') }}"><a class="nav-link" href="#"><i
                                            class="fas fa-users"></i> Users</a>
                                </li> -->

                            </ul>
                        </li>


                    </ul>
                </aside>
            </div>

            <!-- Main Content -->
            @yield('content')

            <footer class="main-footer">
                <div class="footer-left">
                    Copyright &copy; 2022 <div class="bullet"></div> Our Capstone <div class="bullet">
                    </div> All Rights
                    Reserved.
                </div>
                <div class="footer-right">

                </div>
            </footer>
        </div>
    </div>

    <!-- General JS Scripts -->
    <script src="{{ asset('assets/modules/popper.js') }}"></script>
    <script src="{{ asset('assets/modules/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/modules/nicescroll/jquery.nicescroll.min.js') }}"></script>
    <script src="{{ asset('assets/js/stisla.js') }}"></script>


    <!-- JS Libraies -->

    <!-- Page Specific JS File -->

    <!-- Template JS File -->
    <script src="{{ asset('assets/js/scripts.js') }}"></script>
    <script src="{{ asset('assets/js/custom.js') }}"></script>
    <script>
    //active select2
    // $(document).ready(function() {
    //     $('select').select2({
    //         theme: 'bootstrap4',
    //         width: 'style',
    //     });
    // });

    //flash message
    // <?php if (session()->has('success')) { ?>
    // swal({
    //     type: "success",
    //     icon: "success",
    //     title: "BERHASIL!",
    //     text: "{{ session('success') }}",
    //     timer: 1500,
    //     showConfirmButton: false,
    //     showCancelButton: false,
    //     buttons: false,
    // });
    // <?php } elseif (session()->has('error')) { ?>
    // swal({
    //     type: "error",
    //     icon: "error",
    //     title: "GAGAL!",
    //     text: "{{ session('error') }}",
    //     timer: 1500,
    //     showConfirmButton: false,
    //     showCancelButton: false,
    //     buttons: false,
    // });
    // <?php } ?>
    </script>
    @yield('internalScript')
</body>

</html>