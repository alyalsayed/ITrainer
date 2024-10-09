@extends('layouts.master')

@section('title', 'Sessions')

@section('content')
<div class="container py-5">
    <h1>Sessions for {{ $track->name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <a href="{{ route('admin.tracks.sessions.create', $track->id) }}" class="btn btn-primary mb-3">Add Session</a>

    @if($sessions->isEmpty())
        <div class="alert alert-info">No sessions available for this track.</div>
    @else
        <table class="table table-bordered mt-4">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Start Time</th>
                    <th>End Time</th>
                    <th>Location</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr>
                    <td>{{ $session->name }}</td>
                    <td>{{ $session->session_date->format('Y-m-d') }}</td>
                    <td>{{ $session->start_time }}</td>
                    <td>{{ $session->end_time }}</td>
                    <td>{{ ucfirst($session->location) }}</td>
                    <td>
                        <a href="{{ route('admin.tracks.sessions.attendance.index', [$track->id, $session->id]) }}" class="btn btn-sm btn-info">Attendance</a>
                        <a href="{{ route('admin.tracks.sessions.edit', [$track->id, $session->id]) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('admin.tracks.sessions.destroy', [$track->id, $session->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this session?');">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
@endsection
