<html itemscope itemtype="http://schema.org/Product" prefix="og: http://ogp.me/ns#" xmlns="http://www.w3.org/1999/html">
<head>
    <meta charset="utf-8">
    <title> Meeting </title>
    <meta http-equiv="content-type" content="text/html;charset=utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon  -->
    @if(!empty($logo->favicon))
        <link rel="shortcut icon" href="{{asset($logo->favicon)}}" />
    @else
        <link rel="shortcut icon" href="{{asset('img/favicon.png')}}" />
    @endif
    <meta http-equiv="Content-Security-Policy"
          content="default-src *;
                  style-src * 'self' 'unsafe-inline' 'unsafe-eval';
                  script-src * 'self' 'unsafe-inline' 'unsafe-eval';">

    <script src="https://cdn.onesignal.com/sdks/OneSignalSDK.js" async=""></script>
    <script>
        window.OneSignal = window.OneSignal || [];
        OneSignal.push(function() {
            OneSignal.init({
                appId: "{{$meeting->app_id}}",
            });
        });
    </script>
</head>
<body>
<script src="https://meet.jit.si/external_api.js"></script>
@if ($inTeam && $user->hasAnyRole(['manager', 'admin', 'user']))
<script>

    var domain = "meet.jit.si";
    var options = {
        roomName: '{{$meeting->meeting_id}}',
        userInfo: {
            email: '{{$user->email??'Moderator'}}',
            displayName: '{{$user->name??'Moderator'}}'
        },
        devices: {
            audioInput: '<deviceLabel>',
            audioOutput: '<deviceLabel>',
            videoInput: '<deviceLabel>'
        },
        width: "100%",
        height: "100%",
        parentNode: undefined,
        configOverwrite: {
            disableDeepLinking: true,
            participantsPane: {
                hideModeratorSettingsTab: false,
                hideMoreActionsButton: false,
                hideMuteAllButton: false,
            },
            disablePolls: false,
            screenshotCapture : {
                enabled: true,
                mode: 'always',
            },
            disableAudioLevels: false,
            enableNoAudioDetection: true,
            startWithAudioMuted: false,
            disableSearch: false,
            maxFullResolutionParticipants: 2,
            localRecording: {
                disable: false,
                disableSelfRecording: false,
            },
            disableResponsiveTiles: false,
            hideLobbyButton: false,
            enableLobbyChat: true,
            requireDisplayName: false,
            lobby: {
                autoKnock: false,
                enableChat: true,
            },
            securityUi: {
                hideLobbyButton: false,
                disableLobbyPassword: false,
            },
            disableShortcuts: false,
            enableClosePage: false,
            defaultLocalDisplayName: 'Moderator',
            defaultRemoteDisplayName: 'Moderator',
            hideDisplayName: false,
            hideDominantSpeakerBadge: false,
            defaultLanguage: 'en',
            disableProfile: false,
            hideEmailInSettings: true,
            noticeMessage: 'Welcome to the meeting. Please specify your name in your profile settings',
            prejoinConfig: {
                enabled: true,
                hideDisplayName: false,

            },
            readOnlyName: false,
            enableInsecureRoomNameWarning: false,
            inviteAppName: 'SMBwebcast',
            toolbarButtons: [
                'camera',
                'chat',
                'closedcaptions',
                'desktop',
                'download',
                'embedmeeting',
                'fullscreen',
                'hangup',
                'livestreaming',
                'microphone',
                'participants-pane',
                'profile',
                'recording',
            ],
            breakoutRooms: {
                hideAddRoomButton: false,
                hideAutoAssignButton: false,
                hideJoinRoomButton: false,
            },
            disableAddingBackgroundImages: false,
            hideRecordingLabel: false,
            hideParticipantsStats: false,
            useHostPageLocalStorage: true,
            remoteVideoMenu: {
                disabled: false,
                disableKick: false,
                disableGrantModerator: false,
                disablePrivateChat: false,
            },
            disableInviteFunctions: false,
            logoClickUrl: 'https://live.smbwebcast.com',
            logoImageUrl: 'https://live.smbwebcast.com/img/logo.png',
            legalUrls: {
                helpCentre: 'https://support.smbbizapps.com/smbwebcast/live/welcome',
                privacy: 'https://live.smbwebcast.com/privacy-policy',
                terms: 'https://live.smbwebcast.com/terms'
            },


        },


        interfaceConfigOverwrite: {
            APP_NAME: 'SMBwebcast',
            DEFAULT_WELCOME_PAGE_LOGO_URL: 'https://live.smbwebcast.com/img/logo.png',
            MOBILE_APP_PROMO: false,
            SETTINGS_SECTIONS: [ 'devices', 'language', 'moderator', 'profile', 'sounds', 'more' ],
            SHOW_CHROME_EXTENSION_BANNER: false,
            SHOW_JITSI_WATERMARK: false,
            SHOW_POWERED_BY: false,
            SHOW_PROMOTIONAL_CLOSE_PAGE: false,
            SUPPORT_URL: 'https://support.smbbizapps.com/smbwebcast/live/welcome',
            DISABLE_DOMINANT_SPEAKER_INDICATOR: false,
            DISABLE_TRANSCRIPTION_SUBTITLES: false,
            DISABLE_VIDEO_BACKGROUND: true,
            PROVIDER_NAME: 'SMBwebcast',
        },
    }

    var userAgent = window.navigator.userAgent;
    var iOS = /iPad|iPhone|iPod/.test(userAgent);
    var iOSVersion = null;

    if (iOS) {
        var regex = /OS (\d+)_(\d+)_?(\d+)?/;
        var match = regex.exec(navigator.userAgent);
        if (match !== null) {
            iOSVersion = parseInt(match[1], 10);
        }
    }

    if (iOS && iOSVersion > 9) {
        alert("SMBwebcast may not be compatible with certain recent versions of iOS due to certain restrictions that Apple has enforced. While we work on an iOS app as the solution, we recommend that you use live.smbwebcast.com on any modern desktop browser, or Android phone.");
        var api = new JitsiMeetExternalAPI(domain, options);
    } else {
        var api = new JitsiMeetExternalAPI(domain, options);
    }
</script>
@else
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

            configOverwrite: {
                disableDeepLinking: true,
                participantsPane: {
                    hideModeratorSettingsTab: true,
                    hideMoreActionsButton: false,
                    hideMuteAllButton: true,
                },
                disablePolls: false,
                screenshotCapture : {
                    enabled: true,
                    mode: 'always',
                },
                disableAudioLevels: false,
                enableNoAudioDetection: true,
                disableRemoveRaisedHandOnFocus: false,
                startWithAudioMuted: true,
                maxFullResolutionParticipants: 2,
                localRecording: {
                    disable: false,
                    disableSelfRecording: true,
                },
                disableResponsiveTiles: false,
                hideLobbyButton: false,
                enableLobbyChat: true,
                requireDisplayName: false,
                lobby: {
                    autoKnock: false,
                    enableChat: true,
                },
                securityUi: {
                    hideLobbyButton: false,
                    disableLobbyPassword: true,
                },
                disableShortcuts: true,
                enableClosePage: false,
                defaultLocalDisplayName: 'Guest',
                defaultRemoteDisplayName: 'Guest',
                hideDisplayName: false,
                hideDominantSpeakerBadge: false,
                defaultLanguage: 'en',
                disableProfile: false,
                hideEmailInSettings: true,
                noticeMessage: 'Welcome to the meeting. Please specify your name in your profile settings',
                prejoinConfig: {
                    enabled: true,
                    hideDisplayName: false,
                    hideExtraJoinButtons: ['no-audio', 'by-phone'],
                },
                readOnlyName: false,
                enableInsecureRoomNameWarning: false,
                inviteAppName: 'SMBwebcast',
                toolbarButtons: [
                    'camera',
                    'chat',
                    'closedcaptions',
                    'download',
                    'fullscreen',
                    'profile',
                    'embedmeeting',
                    @if($meeting->microphone)
                        'microphone',
                    @endif
                    @if($meeting->desktop)
                        'desktop',
                    @endif
                ],



                analytics: {
                    disabled: true,
                },
                breakoutRooms: {
                    hideAddRoomButton: true,
                    hideAutoAssignButton: true,
                    hideJoinRoomButton: false,
                },
                disableAddingBackgroundImages: false,
                hideRecordingLabel: true,
                hideParticipantsStats: true,
                useHostPageLocalStorage: true,
                remoteVideoMenu: {
                    disabled: true,
                    disableKick: true,
                    disableGrantModerator: true,
                    disablePrivateChat: false,
                },
                disableInviteFunctions: true,
                logoClickUrl: 'https://live.smbwebcast.com',
                logoImageUrl: 'https://live.smbwebcast.com/img/logo.png',
                legalUrls: {
                    helpCentre: 'https://support.smbbizapps.com/smbwebcast/live/welcome',
                    privacy: 'https://live.smbwebcast.com/privacy-policy',
                    terms: 'https://smbwebcast.com/terms'
                },

            },


            interfaceConfigOverwrite: {
                APP_NAME: 'SMBwebcast',
                DEFAULT_WELCOME_PAGE_LOGO_URL: 'https://live.smbwebcast.com/img/logo.png',
                MOBILE_APP_PROMO: false,
                SETTINGS_SECTIONS: [ 'devices', 'language', 'moderator', 'profile', 'sounds', 'more' ],
                SHOW_CHROME_EXTENSION_BANNER: false,
                SHOW_JITSI_WATERMARK: false,
                SHOW_POWERED_BY: false,
                SHOW_PROMOTIONAL_CLOSE_PAGE: false,
                SUPPORT_URL: 'https://support.smbbizapps.com/smbwebcast/live/welcome',
            },

        }

        var userAgent = window.navigator.userAgent;
        var iOS = /iPad|iPhone|iPod/.test(userAgent);
        var iOSVersion = null;

        if (iOS) {
            var regex = /OS (\d+)_(\d+)_?(\d+)?/;
            var match = regex.exec(navigator.userAgent);
            if (match !== null) {
                iOSVersion = parseInt(match[1], 10);
            }
        }

        if (iOS && iOSVersion > 9) {
            alert("SMBwebcast may not be compatible with certain recent versions of iOS due to certain restrictions that Apple has enforced. While we work on an iOS app as the solution, we recommend that you use live.smbwebcast.com on any modern desktop browser, or Android phone.");
            var api = new JitsiMeetExternalAPI(domain, options);
        } else {
            var api = new JitsiMeetExternalAPI(domain, options);
        }
    </script>
@endif

</body>
</html>
