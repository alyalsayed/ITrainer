<nav class="navbar navbar-expand-sm navbar-light bg-light mt-3 shadow-sm">
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#adminSidebar" aria-controls="adminSidebar" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="adminSidebar">
        <ul class="nav navbar-nav w-100">

            {{-- Dashboard link based on user type --}}
            <li class="nav-item">
                <a href="{{ Auth::user()->userType === 'admin' ? route('admin.dashboard') : (Auth::user()->userType === 'instructor' ? route('instructor.dashboard') : route('student.dashboard')) }}"
                   class="nav-link {{ request()->routeIs('admin.dashboard') || request()->routeIs('instructor.dashboard') || request()->routeIs('student.dashboard') ? 'active' : '' }}">
                    <i class="menu-icon fa fa-tachometer-alt"></i> Dashboard
                </a>
            </li>

            {{-- Admin-specific menu --}}
            @if(Auth::user()->userType === 'admin')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-user-cog"></i> Admin Menu
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-users"></i><a href="{{ route('admin.users.index') }}">Manage Users</a></li>
                        <li><i class="fa fa-cogs"></i><a href="{{ route('admin.settings.index') }}">Settings</a></li>
                    </ul>
                </li>

                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-road"></i> Tracks
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('admin.tracks.index') }}">All Tracks</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('admin.tracks.create') }}">Add Track</a></li>
                    </ul>
                </li>
            @endif

            {{-- Instructor-specific menu --}}
            @if(Auth::user()->userType === 'instructor')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-tasks"></i> Tasks
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('tasks.index') }}">All Tasks</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('tasks.create') }}">Add Task</a></li>
                    </ul>
                </li>
            @endif

            {{-- Student-specific menu --}}
            @if(Auth::user()->userType === 'student')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-graduation-cap"></i> Student Menu
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-book"></i><a href="">My Courses</a></li>
                        <li><i class="fa fa-list"></i><a href="">Assignments</a></li>
                    </ul>
                </li>
            @endif

            {{-- Common links --}}
            @if(Auth::user()->userType === 'admin' || Auth::user()->userType === 'instructor' || Auth::user()->userType === 'student')
                <li>
                    <a href="{{ route('chat.index') }}"><i class="menu-icon fa fa-comments"></i> Chat</a>
                </li>
                <li>
                    <a href="{{ route('todo.index') }}"><i class="menu-icon fa fa-list"></i> To Do</a>
                </li>
                <li>
                    <a href="{{ route('sessions.index') }}"><i class="menu-icon fa fa-calendar"></i> Sessions</a>
                </li>
            @endif

        </ul>
    </div>
</nav>
