@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="form-group">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="Enter Email Address..." required autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
        </span>
            @enderror

        </div>

        <div class="form-group">
            <input id="password" type="password" class="form-control @error('password') is-invalid @enderror" name="password" placeholder="Enter Password" value="{{ old('password') }}" required autocomplete="new-password" autofocus>

            @error('password')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
        </span>
            @enderror

        </div>
        <div class="form-group">
            <input type="password" name="password_confirmation" class="form-control form-control-user" id="exampleInputPassword" placeholder="Confirm Password" required autocomplete="new-password">
        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">Reset</button>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="/">Back to Login</a>
    </div>

@endsection

