@extends('errors::minimal')

@section('title', __('Service Unavailable'))
@section('code', '503')
@section('message')
    An error occurred, please contact support {!! '<a href="mailto:support@smbbizapps.com">support@smbbizapps.com</a>' !!}
@endsection
