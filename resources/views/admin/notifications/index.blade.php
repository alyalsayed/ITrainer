@can('manage-notifications')
@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>Notification Settings</h1>

    <form action="{{ route('admin.settings.notifications.update') }}" method="POST">
        @csrf
        @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
        @method('PUT')

        @foreach($settings as $setting)
            @if (str_contains($setting->key, 'notification'))
                <div class="form-group">
                    <label for="{{ $setting->key }}">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                    <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" class="form-control">
                </div>
            @endif
        @endforeach

        <button type="submit" class="btn btn-primary">Update Notification Settings</button>
    </form>

    <!-- Display notifications -->
    <h2>Your Notifications</h2>
    <div id="notification-list"></div>
</div>

<script>
    function fetchNotifications() {
        $.ajax({
            url: '{{ route('admin.notifications.fetch') }}', // Update to your actual route for fetching notifications
            method: 'GET',
            success: function(data) {
                let notificationList = $('#notification-list');
                notificationList.empty();

                if (data.length === 0) {
                    notificationList.append('<p>No new notifications.</p>');
                } else {
                    data.forEach(function(notification) {
                        notificationList.append(`
                            <div class="alert alert-info">
                                <p>${notification.message}</p>
                                <a href="#" class="btn btn-sm btn-success mark-as-read" data-id="${notification.id}">Mark as read</a>
                            </div>
                        `);
                    });
                }
            }
        });
    }

    $(document).on('click', '.mark-as-read', function(e) {
        e.preventDefault();

        const id = $(this).data('id');
        $.ajax({
            url: `{{ url('/admin/notifications') }}/${id}/read`, // Correct URL for marking as read
            method: 'PUT',
            success: function(response) {
                fetchNotifications(); // Refresh notifications after marking one as read
                alert(response.success); // Show success message
            },
            error: function(xhr) {
                alert(xhr.responseJSON.error); // Show error message
            }
        });
    });

    $(document).ready(function() {
        fetchNotifications();

        // Optional: Poll for new notifications every minute
        setInterval(fetchNotifications, 60000); // Fetch every 60 seconds
    });
</script>
@endsection

@endcan
