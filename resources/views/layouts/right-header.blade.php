<div class="top-left">
    <div class="navbar-header">
        <a class="navbar-brand" href="./"><img src="{{ asset('images/logo.png') }}" alt="Logo"></a>
        <a class="navbar-brand hidden" href="./"><img src="{{ asset('images/logo2.png') }}" alt="Logo"></a>
        <a id="menuToggle" class="menutoggle"><i class="fa fa-bars"></i></a>
    </div>
</div>

<div class="top-right">
    <div class="header-menu">
        <div class="header-left">
            <button class="search-trigger"><i class="fa fa-search"></i></button>
            <div class="form-inline">
                <form class="search-form">
                    <input class="form-control mr-sm-2" type="text" placeholder="Search ..." aria-label="Search">
                    <button class="search-close" type="submit"><i class="fa fa-close"></i></button>
                </form>
            </div>

              <!-- Bootstrap Dropdown for Language Switcher -->
            <div class="dropdown">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="languageDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-globe"></i>
                </button>
                <div class="dropdown-menu" aria-labelledby="languageDropdown">
                    @foreach(LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}" href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Task Notification Dropdown -->
            <div class="dropdown for-notification">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="notification" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-bell"></i>
                    @php
                        $unreadNotificationsCount = Auth::user()->unreadNotifications->count();
                    @endphp
                    <span class="count bg-danger">{{ $unreadNotificationsCount > 0 ? $unreadNotificationsCount : '' }}</span>
                </button>

                <div class="dropdown-menu dropdown-menu-right p-0" aria-labelledby="notification">
                    <div class="dropdown-header bg-primary text-white">
                        <strong>Notifications</strong>
                    </div>

                    @if($unreadNotificationsCount === 0)
                        <div class="dropdown-item text-center text-muted">
                            <p>No new notifications</p>
                        </div>
                    @else
                    @foreach(Auth::user()->unreadNotifications as $notification)
                    @if($notification->type === 'App\Notifications\TaskAddedNotification')
                        @php
                            $sessionId = $notification->data['session_id'] ?? null; 
                            $taskId = $notification->data['task_id'] ?? null; 
                        @endphp
                        @if($sessionId && $taskId)
                            <div class="dropdown-item d-flex align-items-center">
                                <a href="{{ route('sessions.tasks.show', ['session' => $sessionId, 'task' => $taskId]) }}" class="flex-grow-1">
                                    <div class="icon-circle bg-info text-white mr-2">
                                        <i class="fa fa-tasks"></i>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                        <span class="font-weight-bold">New Task: {{ $notification->data['task_name'] }}</span>
                                        <div class="small text-muted">
                                            Description: {{ $notification->data['task_description'] ?? 'No description available' }}
                                        </div>
                                        <div class="small text-muted">
                                            Due Date: {{ $notification->data['task_due_date'] ?? 'No due date' }}
                                        </div>
                                    </div>
                                </a>
                                <form id="mark-as-read-{{ $notification->id }}" action="{{ route('notifications.markAsRead', $notification->id) }}" method="GET" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" title="Mark as read">
                                        <i class="fa fa-check m-auto"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endif
                    @elseif($notification->type === 'App\Notifications\NewSessionCreated')
                        @php
                            $sessionId = $notification->data['session_id'] ?? null; 
                        @endphp
                        @if($sessionId)
                            <div class="dropdown-item d-flex align-items-center">
                                <a href="{{ route('sessions.show', $sessionId) }}" class="flex-grow-1">
                                    <div class="icon-circle bg-warning text-white mr-2">
                                        <i class="fa fa-calendar"></i>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                        <span class="font-weight-bold">New Session: {{ $notification->data['session_name'] }}</span>
                                        <div class="small text-muted">
                                            Location: {{ $notification->data['location'] }}
                                        </div>
                                        <div class="small text-muted">
                                            Date: {{ $notification->data['session_date'] }}
                                        </div>
                                    </div>
                                </a>
                                <form id="mark-as-read-{{ $notification->id }}" action="{{ route('notifications.markAsRead', $notification->id) }}" method="GET" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm" title="Mark as read">
                                        <i class="fa fa-check m-auto"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endif
                    @elseif($notification->type === 'App\Notifications\NotesPublished')
                        @php
                            $sessionId = $notification->data['session_id'] ?? null;
                        @endphp
                        @if($sessionId)
                            <div class="dropdown-item d-flex align-items-center">
                                <a href="{{ route('notes.index', $sessionId) }}" class="flex-grow-1">
                                    <div class="icon-circle bg-info text-white mr-2">
                                        <i class="fa fa-book"></i>
                                    </div>
                                    <div>
                                        <div class="small text-gray-500">{{ $notification->created_at->diffForHumans() }}</div>
                                        <span class="font-weight-bold d-block">New Notes Published:</span>
                                        <span class="font-weight-bold">Session: {{ $notification->data['session_name'] }}</span>

                                    </div>
                                </a>
                                <form id="mark-as-read-{{ $notification->id }}" action="{{ route('notifications.markAsRead', $notification->id) }}" method="GET" style="display: inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-primary btn-sm m-3" title="Mark as read">
                                        <i class="fa fa-check m-auto"></i>
                                    </button>
                                </form>
                            </div>
                            <div class="dropdown-divider"></div>
                        @endif
                    @endif
                @endforeach
                
                @endif

                    <div class="dropdown-item text-center">
                        <a href="{{ route('notifications.markAllAsRead') }}">
                            <strong>Mark all as read</strong>
                        </a>
                    </div>
                    <div class="dropdown-item text-center small text-gray-500">
                        <a href="{{ route('notifications.index') }}">View All Notifications</a>
                    </div>
                </div>
            </div>

            <!-- Message Notification Dropdown -->
            <div class="dropdown for-message">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope"></i>
                    <span class="count bg-primary">4</span>
                </button>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="message">
                    <p class="red">You have 1 Mail</p>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar" src="{{ asset('images/avatar/1.jpg') }}"></span>
                        <div class="message media-body">
                            <span class="name float-left">Jonathan Smith</span>
                            <span class="time float-right">Just now</span>
                            <p>Hello, this is an example message</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="user-area dropdown float-right">
            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <img class="user-avatar rounded-circle" src="{{ asset('images/admin.jpg') }}" alt="User Avatar">
            </a>

            <div class="user-menu dropdown-menu">
                <a class="nav-link" href={{ route('profile.edit') }}><i class="fa fa-user"></i> My Profile</a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>

                <a class="nav-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fa fa-power-off"></i> Logout
                </a>
            </div>
        </div>
    </div>
</div>
