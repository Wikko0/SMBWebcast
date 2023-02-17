<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="SMBWebcast">
    <meta name="copyright" content="Copyright (c) 2023 Wikko0 for SMBWebcast">
    @if(!empty($logo->favicon))
        <link rel="shortcut icon" href="{{asset($logo->favicon)}}" />
    @else
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" />
@endif
<!-- CSS-->

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet" />
    <link href="{{asset('plugins/summernote/dist/summernote.css')}}" rel="stylesheet" />
    <script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>

    <title>Admin Panel | {{$settings->app_name}}</title>

</head>

<body id="page-top">

<!-- Page Wrapper -->
<div id="wrapper">

@include('manager.navigation')

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

                <!-- Topbar Navbar -->
                <ul class="navbar-nav ml-auto">

                    <!-- Nav Item - User Information -->
                    <li class="nav-item dropdown no-arrow">
                        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span class="mr-2 d-none d-lg-inline text-gray-600 small">{{ Auth::user()->name }}</span>
                            @if(Auth::user()->image)
                                <img class="img-profile rounded-circle" src="{{asset(Auth::user()->image)}}">
                            @else
                                <img class="img-profile rounded-circle" src="{{asset('img/user.jpg')}}">
                            @endif
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                            <a class="dropdown-item" href="/manager/profile">
                                <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                Profile
                            </a>
                            <a class="dropdown-item" href="/manager/profile">
                                <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                Change Password
                            </a>
                            <div class="dropdown-divider"></div>
                            <form id="form" action="{{ route('logout') }}" method="POST">
                                @csrf
                                <a class="dropdown-item" href="javascript:;" onclick="document.getElementById('form').submit();">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>

                            </form>

                        </div>
                    </li>

                </ul>
            </nav>
            <!-- End of Topbar -->

            <!-- Begin Page Content -->
            <div class="container-fluid">
                <!-- Page Heading -->
                <div class="d-sm-flex align-items-center justify-content-between mb-4">
                    <h1 class="h3 mb-0 text-gray-800">{{$title}}</h1>
                </div>
                @yield('content')
            </div>
        </div>

        <!-- Footer -->
        <footer class="sticky-footer bg-white">
            <div class="container my-auto">
                <div class="copyright text-center my-auto">
                    <span><a href="https://support.smbbizapps.com/smbwebcast/live/getting-started">SBMwebcast | Support</a></span>
                </div>
            </div>
        </footer>
        <!-- End of Footer -->
    </div>
    <!-- End of Content Wrapper -->
</div>
<!-- End of Page Wrapper -->

<!-- Scroll to Top Button-->
<a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
</a>
<!-- ajax modal  -->
<div class="modal fade" id="mymodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- content will be load here -->
            <div id="dynamic-content"></div>
        </div>
    </div>
</div>

<!-- Bootstrap core JavaScript-->

<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>
<script type="text/javascript" src="{{asset('js/sb-admin-2.min.js')}}"></script>

<!--sweet alert2 JS -->
<script src="{{asset('js/plugins/sweetalert.min.js')}}"></script>
<!-- OneSignal-->
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "{{$onesignal->app_id}}",
        });
    });
</script>

</body>
</html>
