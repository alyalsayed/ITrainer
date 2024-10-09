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
            <!-- Search Trigger -->
            <button class="search-trigger">
                <i class="fa fa-search"></i>
            </button>

            <!-- Search Box -->
            <div class="form-inline search-box">
                <form class="search-form">
                    <input class="form-control search-input" type="text" placeholder="Search ..." aria-label="Search" autofocus>
                    <button class="search-close" type="button" aria-label="Close search">
                        <i class="fa fa-times"></i>
                    </button>
                </form>
            </div>

                <!-- Notifications Dropdown -->
                <div class="dropdown for-notification">
                    <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary dropdown-toggle" type="button" id="notification"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fa fa-bell"></i>
                        <span class="count bg-danger" id="notification-count">0</span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="notification" id="notification-menu">
                        <p class="red">You have <span id="notification-count-text">0</span> Notification(s)</p>
                        <!-- Dynamic notifications will be injected here -->
                        <div id="notification-list"></div>
                    </div>
                </div>

            <!-- Messages Dropdown -->
            <div class="dropdown for-message">
                <button class="btn btn-secondary dropdown-toggle" type="button" id="message" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false">
                    <i class="fa fa-envelope"></i>
                    <span class="count bg-primary">4</span>
                </button>
                <div class="dropdown-menu" aria-labelledby="message">
                    <p class="red">You have 1 Mail</p>
                    <a class="dropdown-item media" href="#">
                        <span class="photo media-left"><img alt="avatar"
                                src="{{ asset('images/avatar/1.jpg') }}"></span>
                        <div class="message media-body">
                            <span class="name float-left">Jonathan Smith</span>
                            <span class="time float-right">Just now</span>
                            <p>Hello, this is an example msg</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>

        <div class="user-area dropdown float-right">
            <a href="#" class="dropdown-toggle active" data-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <img class="user-avatar rounded-circle" src="{{ asset('images/admin.jpg') }}" alt="User Avatar">
            </a>

            <div class="user-menu dropdown-menu">
                <a class="nav-link" href={{ route('profile.edit') }}><i class="fa fa-user"></i>My Profile</a>

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

    <script>
        // Fetch notifications and update the header
        function fetchNotifications() {
            $.ajax({
                url: '{{ route('admin.notifications.fetch') }}',
                method: 'GET',
                success: function(data) {
                    let notificationCount = data.length;
                    $('#notification-count').text(notificationCount);
                    $('#notification-count-text').text(notificationCount);
                    let notificationList = $('#notification-list');
                    notificationList.empty();

                    if (notificationCount === 0) {
                        notificationList.append('<p>No new notifications.</p>');
                    } else {
                        data.forEach(function(notification) {
                            notificationList.append(`
                                <a class="dropdown-item media" href="{{ url('/admin/notifications/') }}/${notification.id}/read">
                                    <i class="fa fa-check"></i>
                                    <p>${notification.message}</p>
                                </a>
                            `);
                        });
                    }
                }
            });
        }

        $(document).ready(function() {
            fetchNotifications();

            // Optional: Poll for new notifications every minute
            setInterval(fetchNotifications, 60000); // Fetch every 60 seconds
        });
    </script>
