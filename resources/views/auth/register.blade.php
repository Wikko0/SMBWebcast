@extends('layouts.app')

@section('content')

    <form class="user" action="{{ route('register') }}" method="post">
        @csrf
        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" id="name" aria-describedby="name" placeholder="Enter Name..." required>
            @error('name')
            <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="email" class="form-control form-control-user @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" id="email" aria-describedby="emailHelp" placeholder="Enter Email Address..." required>
            @error('email')
            <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <div class="form-group">
            <input type="password" class="form-control form-control-user @error('password') is-invalid @enderror" name="password" id="exampleInputPassword" placeholder="Password" required autocomplete="new-password">
            @error('password')
            <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>

        <div class="form-group">
            <input type="password" name="password_confirmation" class="form-control form-control-user" id="exampleInputPassword" placeholder="Confirm Password" required autocomplete="new-password">
        </div>

        <div class="form-group">
            <input type="text" class="form-control form-control-user @error('team') is-invalid @enderror" name="team" id="exampleInputTeam" placeholder="Team name" required>
            @error('team')
            <span class="invalid-feedback" role="alert">
           <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">Register</button>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="/">Back to Login</a>
    </div>

@endsection
