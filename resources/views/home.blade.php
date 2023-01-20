@extends('layouts.app')

@section('content')
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
            <input type="password" name="password" class="form-control form-control-user @error('password') is-invalid @enderror"" id="exampleInputPassword" placeholder="Password" required>
            @error('password')
            <span class="invalid-feedback" role="alert">
        <strong>{{ $message }}</strong>
        </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">Login</button>
    </form>

@endsection
