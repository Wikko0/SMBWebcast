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
        height: "100%",
        parentNode: undefined,
        configOverwrite: {disableDeepLinking: true},
    }
    var api = new JitsiMeetExternalAPI(domain, options);


</script>

<script>
    if (navigator.userAgent.match(/(iPad|iPhone|iPod)/g)) {
        // Replace iframe tag with embed tag
        var iframes = document.getElementsByTagName("iframe");
        for (var i = 0; i < iframes.length; i++) {
            var iframe = iframes[i];
            var embed = document.createElement("embed");
            embed.setAttribute("src", iframe.getAttribute("src"));

            // Set width and height attributes to match aspect ratio of original iframe tag
            var width = iframe.getAttribute("width");
            var height = iframe.getAttribute("height");
            var aspectRatio = height / width;
            embed.setAttribute("width", "100%");
            embed.setAttribute("height", "100%");

            iframe.parentNode.replaceChild(embed, iframe);
        }
    }
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
