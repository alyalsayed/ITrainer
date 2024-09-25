<nav class="navbar navbar-expand-sm navbar-default mt-3">
    <div id="main-menu" class="main-menu collapse navbar-collapse">
        <ul class="nav navbar-nav">

            {{-- Dashboard (Visible for all roles, no collapse) --}}
            <li>
                <a href="#"><i class="menu-icon fa fa-laptop"></i>Dashboard</a>
            </li>

            {{-- Instructor-specific menu --}}
            @if(Auth::user()->userType === 'instructor')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-tasks"></i>Tasks
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-list"></i><a href="{{ route('tasks.index') }}">All Tasks</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('tasks.create') }}">Add Task</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-calendar"></i>Sessions
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-calendar"></i><a href="{{ route('sessions.index') }}">All Sessions</a></li>
                        <li><i class="fa fa-plus"></i><a href="{{ route('sessions.create') }}">Add Session</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-sticky-note"></i>Notes
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-sticky-note"></i><a href="#">All Notes</a></li>
                        <li><i class="fa fa-plus"></i><a href="#">Add Note</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-check-square"></i>Attendance
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-check"></i><a href="#">View Attendance</a></li>
                        <li><i class="fa fa-plus"></i><a href="#">Mark Attendance</a></li>
                    </ul>
                </li>
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-sticky-note"></i>Quizzes
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-sticky-note"></i><a href="#">All Quizzes</a></li>
                        <li><i class="fa fa-plus"></i><a href="#">Add Quiz</a></li>
                    </ul>
                </li>
            @endif

            {{-- Admin-specific menu --}}
            @if(Auth::user()->userType === 'admin')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-users"></i>Admin Menu
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-user-cog"></i><a href="#">Manage Users</a></li>
                        <li><i class="fa fa-cogs"></i><a href="#">Settings</a></li>
                        {{-- Add more admin links here --}}
                    </ul>
                </li>
            @endif

            {{-- HR-specific menu --}}
            @if(Auth::user()->userType === 'hr')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-id-badge"></i>HR Menu
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-address-book"></i><a href="#">HR Panel</a></li>
                        <li><i class="fa fa-calendar-check"></i><a href="#">Leave Management</a></li>
                        {{-- Add more HR links here --}}
                    </ul>
                </li>
            @endif

            {{-- Student-specific menu --}}
            @if(Auth::user()->userType === 'student')
                <li class="menu-item-has-children dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="menu-icon fa fa-graduation-cap"></i>Student Menu
                    </a>
                    <ul class="sub-menu children dropdown-menu">
                        <li><i class="fa fa-book"></i><a href="#">My Courses</a></li>
                        <li><i class="fa fa-list"></i><a href="#">Assignments</a></li>
                        {{-- Add more student links here --}}
                    </ul>
                </li>
            @endif

        </ul>
    </div>
</nav>
