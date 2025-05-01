<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link
    href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
    rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Bootstrap 5 JS Bundle (Includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <link rel="stylesheet" href="{{ asset('style.css') }}">
    <title>Rise Academy of Science</title>
    <style>
       .navbar-nav {
            padding: 0;  /* Remove extra padding */
            margin: 0;  /* Remove extra margin */
        }

        .nav-item {
            margin: 0;  /* Remove bottom margin */
            padding: 0;  /* Remove padding */
            line-height: 1;  /* Reduce line height */
        }

        .nav-link {
            display: flex;
            align-items: center;  /* Align icons and text properly */
            gap: 8px; /* Adjust spacing between icon and text */
            padding: 8px 10px; /* Reduce spacing */
        }

        .sidebar-divider {
            display: none; /* Remove extra dividers */
        }
    </style>
</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="dashboard">
                <div class="sidebar-brand-icon rotate-n-15"></div>
                <img src="{{asset('rise-logo.jpeg')}}" class="logo img-profile rounded-circle" alt="">
                <div class="sidebar-brand-text mx-2">Rise Academy</div>
            </a>


            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="{{asset('dashboard')}}">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{asset('students')}}">
                    <i class="fa-solid fa-users"></i>
                    <span>All Students</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{asset('add-student')}}">
                    <i class="fa-solid fa-user"></i>
                    <span>Add New Student</span>
                </a>
            </li>
            
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('staff-members') }}">
                    <i class="fa-solid fa-users"></i> <!-- Changed to a proper staff icon -->
                    <span>Staff Members</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('attendance') }}">
                    <i class="fa-solid fa-user-check"></i> <!-- More relevant for attendance -->
                    <span>Attendance</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('weekly-report') }}">
                    <i class="fa-solid fa-file-alt"></i> <!-- Better suited for reports -->
                    <span>Test Reports</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('account') }}">
                    <i class="fa-solid fa-wallet"></i> <!-- Changed to an accounts-related icon -->
                    <span>Accounts</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('salaries-information') }}">
                    <i class="fa-solid fa-money-check-alt"></i> <!-- More relevant for salaries -->
                    <span>Salaries Information</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ asset('promote-students') }}">
                    <i class="fa-solid fa-level-up-alt"></i> <!-- More relevant for salaries -->
                    <span>Promote Students</span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    {{-- Topbar started --}}

                    <h3>
                        Rise Academy – Transforming Effort into Excellence!
                    </h3>
                                        <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in"
                                aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small"
                                            placeholder="Search for..." aria-label="Search"
                                            aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <div class="topbar-divider d-none d-sm-block"></div>

                        @php
                            $user = Auth::user();
                        @endphp

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ trim($user->firstname . ' ' . ($user->lastname ?? '')) }}</span>
                                <img src="{{ $user->profile_picture ? asset('storage/'. $user->profile_picture) : asset('user.png') }}" 
                                alt="User Avatar" 
                                class="rounded-circle img-fluid" 
                                style="width: 35px; height: 35px;">                    
                                        </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                                aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="{{asset('profile')}}">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#newLogoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->
                <div class="modal fade" id="newLogoutModal" tabindex="-1" role="dialog" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title">Confirm Logout</h5>
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to log out?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                                <a class="btn btn-danger" href="{{ route('logout') }}">Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
                                

