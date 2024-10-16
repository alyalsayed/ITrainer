<nav class="navbar navbar-expand-sm navbar-default mt-3">
    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">

            {{-- Dashboard link based on user type --}}
            @php
            $dashboardRoute = Auth::user()->userType === 'instructor' ? route('instructor.dashboard') :
                              (Auth::user()->userType === 'student' ? route('student.dashboard') :
                              (Auth::user()->userType === 'admin' ? route('admin.dashboard') :
                              (Auth::user()->userType === 'hr' ? route('hr.dashboard') : '')));
            @endphp

            {{-- Dashboard link --}}
            <li>
                <a href="{{ $dashboardRoute }}"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
            </li>

            <li>
                <a href="{{ route('chat.index') }}"><i class="menu-icon fa fa-comments"></i>Chat</a>
            </li>

            {{-- To Do List link --}}
            <li>
                <a href="{{ route('todo.index') }}"><i class="menu-icon fa fa-list"></i>To Do</a>
            </li>

            {{-- Instructor-specific menu --}}
            @if(Auth::user()->userType === 'instructor' || Auth::user()->userType === 'student')
            <li>
                <a href="{{ route('sessions.index') }}"><i class="menu-icon fa fa-calendar"></i>Sessions</a>
            </li>
            <li>
                <a href="{{ route('notifications.index') }}"><i class="menu-icon fa fa-bell"></i>Notifications 
                </a>
            </li>
        @endif
        

           {{-- Admin-specific menu --}}
@if(Auth::user()->userType === 'admin')
<li class="menu-item-has-children dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="menu-icon fa fa-shield"></i>Users
    </a>
    <ul class="sub-menu children dropdown-menu">
        <li><i class="fa fa-user"></i><a href="#">Manage Users</a></li>
        <li><i class="fa fa-tag"></i><a href="#">Manage Roles</a></li>
    </ul>
</li>
<li class="menu-item-has-children dropdown">
    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <i class="menu-icon fa  fa-code-fork"></i>Tracks
    </a>
    <ul class="sub-menu children dropdown-menu">
        <li><i class="fa fa-pencil-square-o"></i><a href="#">Manage Tracks</a></li>
        <li><i class="fa fa-tasks"></i><a href="#">Assign Tracks</a></li>
    </ul>
</li>
@endif


        </ul>
    </div>
</nav>
