<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">
    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="/">
        <div class="sidebar-brand-icon">
            @if(!empty($logo['logo']->logo))
                <img src="{{asset('storage/'.$logo['logo']->logo)}}">
            @else
            <img src="{{asset('img/logo.png')}}">
            @endif
        </div>
        <div class="sidebar-brand-text mx-3">Admin Panel</div>
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

    <li class="nav-item {{ (Request::is('admin/settings')) || (Request::is('admin/email-settings')) || (Request::is('admin/logo-settings'))  ? 'active' : '' }}">
        <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseSetting" aria-expanded="true" aria-controls="collapseSetting">
            <i class="fas fa-fw fa-cog" aria-hidden="true"></i><span>Setting</span>
        </a>
        <div id="collapseSetting" class="collapse {{ (Request::is('admin/settings')) || (Request::is('admin/email-settings')) || (Request::is('admin/logo-settings'))  ? 'show' : '' }}" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ (Request::is('admin/settings')) ? 'active' : '' }}" href="/admin/settings">System Setting</a>
                <a class="collapse-item {{ (Request::is('admin/email-settings')) ? 'active' : '' }}" href="/admin/email-settings">Email Setting</a>
                <a class="collapse-item {{ (Request::is('admin/logo-settings')) ? 'active' : '' }}" href="/admin/logo-settings">Logo & Image</a>
            </div>
        </div>
    </li>
    <li class="nav-item">
        <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseNotificationSetting" aria-expanded="true" aria-controls="collapseNotificationSetting">
            <i class="fas fa-fw fa-bell" aria-hidden="true"></i><span>Notification</span>
        </a>
        <div id="collapseNotificationSetting" class="collapse {{ (Request::is('admin/send-notification')) || (Request::is('admin/notification'))  ? 'show' : '' }}" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ (Request::is('admin/send-notification')) ? 'active' : '' }}" href="/admin/send-notification">Send Notification </a>
                <a class="collapse-item {{ (Request::is('admin/notification')) ? 'active' : '' }}" href="/admin/notification">Setting </a>
            </div>
        </div>
    </li>
     <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>
</ul>
