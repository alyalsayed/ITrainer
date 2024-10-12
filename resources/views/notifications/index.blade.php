@extends('layouts.master')

@section('title', 'Notifications')

@section('content')
<div class="container">
    <h2 class="mb-3">All Notifications</h2>
    @if($notifications->isEmpty())
        <p>No notifications found.</p>
    @else
    @foreach($notifications as $notification)
    <div class="notification-item" style="border-left: 5px solid {{ $notification->read_at ? '#d1e7dd' : '#0d6efd' }}; padding: 10px; margin-bottom: 15px; background-color: {{ $notification->read_at ? '#f8f9fa' : '#e3f2fd' }}; border-radius: 5px; display: flex; align-items: center;">
        <div class="icon" style="flex-shrink: 0; margin-right: 15px;">
            <i class="fa fa-bell" style="font-size: 24px; color: {{ $notification->read_at ? '#6c757d' : '#0d6efd' }};"></i>
        </div>
        <div class="notification-content" style="flex-grow: 1;">
            @if($notification->type === 'App\Notifications\TaskAddedNotification')
                <!-- Existing Task Notification Code -->
            @elseif($notification->type === 'App\Notifications\NewSessionCreated')
                <!-- Existing Session Notification Code -->
            @elseif($notification->type === 'App\Notifications\NotesPublished')
                <strong>{{ $notification->data['session_name'] ?? 'Session name not available' }}</strong>
                <span class="text-muted" style="display: block;">{{ $notification->created_at->diffForHumans() }}</span>
                <p style="margin: 0;">New notes have been published for this session.</p>
                <a href="{{ route('notes.index', $notification->data['session_id']) }}">View Notes</a>
            @endif
        </div>
        @if(!$notification->read_at)
            <a href="{{ route('notifications.markAsRead', $notification->id) }}" class="btn btn-primary btn-sm rounded-circle" style="align-self: center; color: white; background-color: #0d6efd;">&#10004;</a>
        @endif
        <form action="{{ route('notifications.destroy', $notification->id) }}" method="POST" style="display: inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger btn-sm rounded-circle ml-2" onclick="return confirm('Are you sure you want to delete this notification?')" title="Delete">
                <i class="fa fa-trash"></i>
            </button>
        </form>
    </div>
@endforeach


        <!-- Show Delete All Notifications button only if there are notifications -->
        <form action="{{ route('notifications.destroyAll') }}" method="POST" class="mt-3">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete all notifications?');">Delete All Notifications</button>
        </form>
    @endif
</div>
@endsection
