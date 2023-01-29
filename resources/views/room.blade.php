<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    @if(!empty($logo['logo']->favicon))
        <link rel="shortcut icon" href="{{asset('storage/'.$logo['logo']->favicon)}}" />
    @else
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" />
    @endif
    <!-- open-graph -->
    <meta property="og:locale" content="en_US" />
    <meta name="twitter:card" content="summary">

    <meta property="og:url" content="" />
    <meta property="og:type" content="website" />
    <meta property="og:description" content="Join a meeting from web: Or Use meeting ID for mobile app.Meeting ID: " />


    <title> - Meeting Room</title>
    <!-- Custom fonts for this template-->
    <link href="{{asset('vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="{{asset('css/sb-admin-2.min.css')}}" rel="stylesheet">
    <script src='https://meet.jit.si/external_api.js' type="text/javascript"></script>
</head>
<body>
<div id="meeting"></div>
<script type="text/javascript">
    const domain = 'meet.jit.si';
    const options = {
        roomName: '{{$meeting->meeting_id}}',
        userInfo: {
            email: '{{$user->email??'Guest'}}',
            displayName: '{{$user->name??'Guest'}}'
        },
        width: "100%",
        height: 920,
        parentNode: document.querySelector('#meeting'),
        onload: function(){
        }
    };
    const api = new JitsiMeetExternalAPI(domain, options, );

</script>
</body>
</html>
