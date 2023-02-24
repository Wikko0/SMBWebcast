@extends('errors::minimal')

@section('title', __('Not Found'))
@section('code', '404')
@section('message')
    An error occurred, please contact support {!! '<a href="mailto:support@smbbizapps.com">support@smbbizapps.com</a>' !!}
@endsection
