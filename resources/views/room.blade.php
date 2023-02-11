<html itemscope itemtype="http://schema.org/Product" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title> Meeting </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
</head>
<body>
<script src="https://meet.jit.si/external_api.js"></script>
<script>
    var domain = "meet.jit.si";
    var options = {
        roomName: '{{$meeting->meeting_id}}',
        userInfo: {
            email: '{{$user->email??'Guest'}}',
            displayName: '{{$user->name??'Guest'}}'
        },
        devices: {
            audioInput: '<deviceLabel>',
            audioOutput: '<deviceLabel>',
            videoInput: '<deviceLabel>'
        },
        width: "100%",
        height: 800,
        parentNode: undefined,
        configOverwrite: {},
    }
    var api = new JitsiMeetExternalAPI(domain, options);
</script>
</body>
</html>
