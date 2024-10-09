@extends('layouts.master')

@section('title', 'Edit Session')

@section('content')
<div class="container py-5">
    <h1>Edit Session</h1>

    <form action="{{ route('admin.tracks.sessions.update', [$track->id, $session->id]) }}" method="POST">

        @csrf
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @method('PUT')

        <div class="form-group mb-3">
            <label for="name">Session Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $session->name }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="track">Select Track</label>
            <select class="form-control" id="track" name="track_id">
                @foreach ($tracks as $track)
                    <option value="{{ $track->id }}" {{ $track->id == $session->track_id ? 'selected' : '' }}>
                        {{ $track->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="session_date">Session Date</label>
            <input type="date" class="form-control" id="session_date" name="session_date" value="{{ $session->session_date->format('Y-m-d') }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="start_time">Start Time</label>
            <input type="time" class="form-control" id="start_time" name="start_time" value="{{ date('H:i', strtotime($session->start_time)) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="end_time">End Time</label>
            <input type="time" class="form-control" id="end_time" name="end_time" value="{{ date('H:i', strtotime($session->end_time)) }}" required>
        </div>

        <div class="form-group mb-3">
            <label for="location">Location</label>
            <select class="form-control" id="location" name="location">
                <option value="online" {{ $session->location == 'online' ? 'selected' : '' }}>Online</option>
                <option value="offline" {{ $session->location == 'offline' ? 'selected' : '' }}>Offline</option>
            </select>
        </div>

        <div class="form-group mb-3">
            <label for="description">Description (Optional)</label>
            <textarea class="form-control" id="description" name="description" rows="3">{{ $session->description }}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Update Session</button>
        <a href="{{ route('admin.tracks.sessions.index', $track->id) }}" class="btn btn-secondary">Back to List</a>
    </form>
</div>
@endsection
