@extends('layouts.master')

@section('title', 'Create Session')

@section('content')
<div class="container py-5">
    <h1>Create Session</h1>

    <form action="{{ route('admin.tracks.sessions.store', ['track' => $track->id]) }}" method="POST"> <!-- Pass the track ID here -->
        @csrf

        <div class="form-group mb-3">
            <label for="name">Session Name</label>
            <input type="text" class="form-control" id="name" name="name" required>
        </div>

        <div class="form-group mb-3">
            <label for="track">Select Track</label>
            <select class="form-control" id="track" name="track_id" required>
                @foreach ($tracks as $trackOption)
                    <option value="{{ $trackOption->id }}">{{ $trackOption->name }}</option> <!-- Each track option -->
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="session_date">Session Date</label>
            <input type="date" class="form-control" id="session_date" name="session_date" required>
        </div>

        <div class="form-group mb-3">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" required>
        </div>

        <div class="form-group mb-3">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" required>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <select class="form-control" id="location" name="location" required>
                <option value="online">Online</option>
                <option value="offline">Offline</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description (Optional)</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Create Session</button>
        <a href="{{ route('admin.tracks.sessions.index', $track->id) }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
