@extends('layouts.app')

@section('content')
    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif
    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div class="form-group">
            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" required placeholder="Enter Email Address..." autocomplete="email" autofocus>

            @error('email')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
        </span>
            @enderror

        </div>
        <button type="submit" class="btn btn-primary btn-user btn-block">Reset</button>
    </form>
    <hr>
    <div class="text-center">
        <a class="small" href="/">Back to Login</a>
    </div>

@endsection
