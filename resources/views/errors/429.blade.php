@extends('errors::minimal')

@section('title', __('Too Many Requests'))
@section('code', '429')
@section('message')
    An error occurred, please contact support {!! '<a href="mailto:support@smbbizapps.com">support@smbbizapps.com</a>' !!}
@endsection
