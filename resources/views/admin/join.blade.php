@extends('layouts.admin')
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
    @if(!empty($logo->favicon))
        <link rel="shortcut icon" href="{{asset('img/uploads/'.$logo->favicon)}}" />
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
                        <div class="col-lg-12">
                            <div class="p-5">
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
                                                <input type="text" name="meeting_id" required class="form-control form-control-user" placeholder="Meeting ID" value="{{ old('meeting_id')??Cookie::get('last_meeting_id') }}">
                                            </div>
                                            <div class="form-group">
                                                <input type="password" name="password" class="form-control form-control-user" placeholder="Meeting Password(optional)" value="{{ old('password')??Cookie::get('meeting_password')}}">
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
