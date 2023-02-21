<html itemscope itemtype="http://schema.org/Product" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title> Meeting </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
        configOverwrite: {disableDeepLinking: true},
    }
    var api = new JitsiMeetExternalAPI(domain, options);
</script>
<script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
<script>
    window.OneSignal = window.OneSignal || [];
    OneSignal.push(function() {
        OneSignal.init({
            appId: "{{$meeting->app_id}}",
        });
    });
</script>
</body>
</html>
