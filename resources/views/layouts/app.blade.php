<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon  -->
    <link rel="shortcut icon" href="{{asset('favicon.png')}}" />

    <!-- open-graph -->
    <meta property="og:locale" content="en_US" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:description" content="Join and host a meeting by - {{env('APP_NAME')}}" />
    <meta name="twitter:title" content="{{env('APP_NAME')}} - Join Meeting" />
    <meta name="twitter:image" content="{{env('APP_NAME')}}">
    <meta name="twitter:site" content="@ {{env('APP_NAME')}}">

    <meta property="og:title" content="{{env('APP_NAME')}} - Join Meeting" />
    <meta property="og:url" content="{{env('APP_NAME')}}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Join and host a meeting by - {{env('APP_NAME')}}" />
    <meta property="og:image" content="{{env('APP_NAME')}}" />
    <meta property="og:image:alt" content="{{env('APP_NAME')}} - Preview">

    <title>{{env('APP_NAME')}} - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <style type="text/css">
        .bg-login-image{
            background: url('{{asset('img/login-bg.jpg')}}');
            background-size: cover !important;
            background-position: center !important;
        }
    </style>

</head>

<body class="bg-gradient-primary">

<div class="container">

    <!-- Outer Row -->
    <div class="row justify-content-center">

        <div class="col-xl-10 col-lg-12 col-md-9">

            <div class="card o-hidden border-0 shadow-lg my-5">
                <div class="card-body p-0">
                    <!-- Nested Row within Card Body -->
                    <div class="row">
                        <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                        <div class="col-lg-6">
                            <div class="p-5">
                                <div class="text-center">
                                    <a href="/">
                                        <img src="{{asset('img/logo.png')}}"></a><br>
                                    <a href="/"><h1 class="h4 text-gray-900 mb-4">{{env('APP_NAME')}} - Login</h1></a>
                                </div>

                               @yield('content')


                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

    </div>

</div>

<!-- Bootstrap core JavaScript-->
<script src="{{asset('vendor/jquery/jquery.min.js')}}"></script>
<script src="{{asset('vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

<!-- Core plugin JavaScript-->
<script src="{{asset('vendor/jquery-easing/jquery.easing.min.js')}}"></script>

<!-- Custom scripts for all pages-->
<script src="{{asset('js/sb-admin-2.min.js')}}"></script>

</body>

</html>
