@extends('errors::minimal')

@section('title', __('Page Expired'))
@section('code', '419')
@section('message')
    Page Expired. Please refresh page or contact support {!! '<a href="mailto:support@smbbizapps.com">support@smbbizapps.com</a>' !!}
@endsection
