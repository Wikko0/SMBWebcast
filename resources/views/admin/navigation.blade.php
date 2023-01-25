<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            <img src="{{asset('img/logo.png')}}">
        </div>
        <div class="sidebar-brand-text mx-3">MeetAir <sup>Za sq prazno w navigation</sup></div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ (Request::is('admin')) ? 'active' : '' }}"><a class="nav-link" href="/admin"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a> </li>
    <li class="nav-item {{ (Request::is('admin/manage')) ? 'active' : '' }}"><a class="nav-link" href="/admin/manage"><i class="fas fa-fw fa-users"></i><span>Users</span></a></li>
    <li class="nav-item">
        <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseMeeting" aria-expanded="true" aria-controls="collapseMeeting">
            <i class="fas fa-fw fa-video" aria-hidden="true"></i><span>Meeting</span>
        </a>
        <div id="collapseMeeting" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/admin/meeting">All Meeting</a>
                <a class="collapse-item" href="/admin/meeting_history">Meeting History</a>
            </div>
        </div>
    </li>

    <li class="nav-item">
        <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
            <i class="fas fa-fw fa-cog" aria-hidden="true"></i><span>Setting</span>
        </a>
        <div id="collapseSetting" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/admin/system_setting">System Setting</a>
                <a class="collapse-item" href="/admin/api_setting>">API Setting</a>
                <a class="collapse-item" href="/admin/email_setting">Email Setting</a>
                <a class="collapse-item" href="/admin/mobile_ads_setting>">Ads Setting</a>
                <a class="collapse-item" href="/admin/logo_and_image">Logo & Image</a>
                <a class="collapse-item" href="/admin/update">Update</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseNotificationSetting" aria-expanded="true" aria-controls="collapseNotificationSetting">
            <i class="fas fa-fw fa-bell" aria-hidden="true"></i><span>Notification</span>
        </a>
        <div id="collapseNotificationSetting" class="collapse" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/admin/send_notification">Send Notification </a>
                <a class="collapse-item" href="/admin/push_notification_setting>">Setting </a>
            </div>
        </div>
    </li>
    <li class="nav-item"><a class="nav-link" href="/admin/backup_restore"><i class="fas fa-fw fa-database"></i><span>Backup</span></a></li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
