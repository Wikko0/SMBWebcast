@extends('layouts.app')

@section('content')

    <ul class="nav nav-pills mb-4" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link link-left active" id="pills-home-tab" data-toggle="pill" href="#pills-home" role="tab" aria-controls="pills-home" aria-selected="true">Login</a>
        </li>
        <li class="nav-item">
            <a class="nav-link link-right" id="pills-profile-tab" data-toggle="pill" href="#pills-profile" role="tab" aria-controls="pills-profile" aria-selected="false">Join Meeting</a>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">


            <form class="user" action="{{ route('login') }}" method="post">
                @csrf

                <div class="form-group">
                    <input type="email" name="email" class="form-control form-control-user @error('email') is-invalid @enderror" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
                    @error('email')
                    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
                    @enderror
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror" id="exampleInputPassword" placeholder="Password" required>
                    @error('password')
                    <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
            </form>



        </div>
        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
            <form class="user" action="/api" method="post">
                @csrf
                <div class="form-group">
                    <input type="text" name="meeting_id" required class="form-control form-control-user" placeholder="Enter Meeting ID">
                </div>
                <div class="form-group">
                    <input type="password" name="password" class="form-control form-control-user" placeholder="Enter Meeting Password(optional)">
                    <div class="my-2"></div>

                </div>
                <button type="submit" class="btn btn-primary btn-user btn-block">Join Now</button>
            </form>
        </div>
    </div>
    <hr>
    <div class="text-center">
        @if (Route::has('password.request'))
            <a class="small" href="{{ route('password.request') }}">Forgot Password?</a> -
        @endif
        <a class="small" href="/register">Create an account</a> -
        <a class="small" href="https://support.smbbizapps.com/smbwebcast/live/getting-started">Support</a>
    </div>
@endsection
