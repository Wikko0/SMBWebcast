@extends('layouts.user')
@section('content')
    <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon  -->
    @if(!empty($logo['logo']->favicon))
        <link rel="shortcut icon" href="{{asset('storage/'.$logo['logo']->favicon)}}" />
    @else
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" />
@endif
<!-- open-graph -->

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <style type="text/css">
        .bg-login-image{
            background:
                @if(!empty($logo['logo']->image))
url('{{asset('storage/'.$logo['logo']->image)}}');
        @else
url('{{asset('img/login-bg.jpg')}}');
            @endif
            background-size: cover !important;
            background-position: center !important;
        }
        .nav{
            display: flex;
            background-color: #eaecf4;
            border-radius: 0.25rem;
        }
        .nav-item{
            width: 50%;
        }
        .nav-pills .nav-link {
            text-align: center;
            border-radius: .25rem;
        }
        .nav-pills .nav-link.link-left {
            border-top-left-radius: 0.25rem;
            border-top-right-radius: 0rem;
            border-bottom-right-radius: 0rem;
            border-bottom-left-radius: 0.25rem;
        }
        .nav-pills .nav-link.link-right {
            border-top-left-radius: 0rem;
            border-top-right-radius: 0.25rem;
            border-bottom-right-radius: 0.25rem;
            border-bottom-left-radius: 0rem;
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
                                        @if(!empty($logo['logo']->logo))
                                            <img src="{{asset('storage/'.$logo['logo']->logo)}}"></a><br>
                                    @else
                                        <img src="{{asset('img/logo.png')}}"></a><br>
                                    @endif

                                    <a href="/"><h1 class="h4 text-gray-900 mb-4">{{$settings['settings']->app_name ?? 'SMBWebcast'}} - Login</h1></a>
                                </div>
                                @if(session('success'))
                                    <div class="alert alert-success alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                        </button>
                                        <h5><i class="icon fas fa-check"></i> Alert!</h5>
                                        <ul>{{session('success')}}</ul>
                                    </div>
                                @endif
                                @if ($errors->any())
                                    <div class="alert alert-warning alert-dismissible">
                                        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;
                                        </button>
                                        <h5><i class="icon fas fa-exclamation-triangle"></i> Alert!</h5>
                                        @foreach ($errors->all() as $error)
                                            <ul>{{ $error }}</ul>
                                        @endforeach
                                    </div>
                                @endif



                                <div class="tab-content" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


                                        <form class="user" action="/join" method="post">
                                            @csrf
                                            <div class="form-group">
                                                <input type="text" name="meeting_id" required class="form-control form-control-user" placeholder="Enter Meeting ID" value="{{ old('meeting_id') }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-user" placeholder="Enter Meeting Password(optional)" value="{{ old('password') }}">
                                                <div class="my-2"></div>

                                            </div>
                                            <button type="submit" class="btn btn-primary btn-user btn-block">Join Now</button>
                                        </form>



                                    </div>
                                </div>
                                <hr>


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


@endsection
