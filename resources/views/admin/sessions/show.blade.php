@extends('layouts.master')

@section('title', 'Session Details')

@section('content')
<div class="container py-5">
    <h1>Session Details for {{ $session->name }}</h1>

    <div class="mb-4">
        <strong>Date:</strong> {{ $session->session_date->format('F j, Y') }}<br>
        <strong>Start Time:</strong> {{ $session->start_time }}<br>
        <strong>End Time:</strong> {{ $session->end_time }}<br>
        <strong>Location:</strong> {{ $session->location }}<br>
        <strong>Description:</strong> {{ $session->description ?? 'N/A' }}<br>
    </div>

    <a href="{{ route('admin.tracks.sessions.edit', [$track->id, $session->id]) }}" class="btn btn-warning">Edit Session</a>

    <form action="{{ route('admin.tracks.sessions.destroy', [$track->id, $session->id]) }}" method="POST" class="d-inline">
        @csrf
        @method('DELETE')
        <button type="submit" class="btn btn-danger">Delete Session</button>
    </form>

    <a href="{{ route('admin.tracks.sessions.index', $track->id) }}" class="btn btn-secondary">Back to Sessions</a>
</div>
@endsection
