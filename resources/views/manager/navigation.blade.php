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
        <div class="sidebar-brand-text mx-3">{{Auth::user()->team->name}}</div>
    </a>
    <!-- Divider -->
    <hr class="sidebar-divider my-0">
    <li class="nav-item {{ (Request::is('manager')) ? 'active' : '' }}"><a class="nav-link" href="/manager"><i class="fas fa-fw fa-tachometer-alt"></i><span>Dashboard</span></a> </li>
    <li class="nav-item {{ (Request::is('manager/manage')) ? 'active' : '' }}"><a class="nav-link" href="/manager/manage"><i class="fas fa-fw fa-users"></i><span>Users</span></a></li>
    <li class="nav-item {{ (Request::is('manager/meeting'))  ? 'active' : '' }}" >
        <a href="#" class="nav-link" data-toggle="collapse" data-target="#collapseMeeting" aria-expanded="true" aria-controls="collapseMeeting">
            <i class="fas fa-fw fa-video" aria-hidden="true"></i><span>Meeting</span>
        </a>
        <div id="collapseMeeting" class="collapse {{ (Request::is('manager/meeting')) || (Request::is('manager/join')) ? 'show' : '' }}" aria-labelledby="headingUtilities" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item {{ (Request::is('manager/meeting')) ? 'active' : '' }}" href="/manager/meeting">All Meeting</a>
                <a class="collapse-item {{ (Request::is('manager/join')) ? 'active' : '' }}" href="/manager/join">Join Meeting</a>
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
