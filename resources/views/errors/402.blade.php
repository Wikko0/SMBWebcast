@extends('errors::minimal')

@section('title', __('Payment Required'))
@section('code', '402')
@section('message')
    An error occurred, please contact support {!! '<a href="mailto:support@smbbizapps.com">support@smbbizapps.com</a>' !!}
@endsection
