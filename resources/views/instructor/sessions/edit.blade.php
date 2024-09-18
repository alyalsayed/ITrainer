@extends('layouts.master')
@section('title', 'Edit Session')

@section('content')
<div class="container mt-4">
    <h1>Edit Session</h1>

    <form action="{{ route('sessions.update', $session->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="name">Session Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ $session->name }}" required>
        </div>
        <div class="form-group">
            <label for="track_id">Track</label>
            <select id="track_id" name="track_id" class="form-control" required>
                @foreach($tracks as $track)
                    <option value="{{ $track->id }}" {{ $session->track_id == $track->id ? 'selected' : '' }}>
                        {{ $track->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="session_date">Session Date</label>
            <input type="date" id="session_date" name="session_date" class="form-control" value="{{ $session->session_date->format('Y-m-d') }}" required>
        </div>
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time" class="form-control" value="{{ $session->start_time }}" required>
        </div>
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time" class="form-control" value="{{ $session->end_time }}" required>
        </div>
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control">{{ $session->description }}</textarea>
        </div>
        <div class="form-group">
            <label for="location">Location</label>
            <select id="location" name="location" class="form-control">
                <option value="online" {{ $session->location == 'online' ? 'selected' : '' }}>Online</option>
                <option value="offline" {{ $session->location == 'offline' ? 'selected' : '' }}>Offline</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update Session</button>
    </form>
</div>
@endsection
