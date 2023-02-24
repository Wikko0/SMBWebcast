@extends('errors::minimal')

@section('title', __('Forbidden'))
@section('code', '403')
@section('message')
    An error occurred, please contact support {!! '<a href="mailto:support@smbbizapps.com">support@smbbizapps.com</a>' !!}
@endsection
