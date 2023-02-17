

    <!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <!-- Favicon  -->
    @if(!empty($logo->favicon))
        <link rel="shortcut icon" href="{{asset($logo->favicon)}}" />
    @else
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" />
@endif
<!-- open-graph -->
    <meta property="og:locale" content="en_US" />
    <meta name="twitter:card" content="summary">
    <meta name="twitter:description" content="Join and host a meeting by - {{$settings->app_name ?? 'SMBWebcast'}}" />
    <meta name="twitter:title" content="{{$settings->app_name ?? 'SMBWebcast'}} - Join Meeting" />
    <meta name="twitter:image" content="{{$settings->app_name ?? 'SMBWebcast'}}">
    <meta name="twitter:site" content="@ {{$settings->app_name ?? 'SMBWebcast'}}">

    <meta property="og:title" content="{{$settings->app_name ?? 'SMBWebcast'}} - Join Meeting" />
    <meta property="og:url" content="{{$settings->app_name ?? 'SMBWebcast'}}" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Join and host a meeting by - {{$settings->app_name ?? 'SMBWebcast'}}" />
    <meta property="og:image" content="{{$settings->app_name ?? 'SMBWebcast'}}" />
    <meta property="og:image:alt" content="{{$settings->app_name ?? 'SMBWebcast'}} - Preview">

    <title>{{$settings->app_name ?? 'SMBWebcast'}} - Login</title>

    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

</head>

<body class="bg-gradient-primary">

<div class="container">

                                {!! $settings->policy !!}
</div>
</body>

</html>
