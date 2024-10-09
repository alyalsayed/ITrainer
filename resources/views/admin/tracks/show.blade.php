@extends('layouts.master')

@section('title', 'Track Details')

@section('content')
<div class="container py-5">
    <h1>Track Details</h1>

    <div class="card mb-4">
        <div class="card-header">
            Track: {{ $track->name }}
        </div>
        <div class="card-body">
            <p><strong>Description:</strong> {{ $track->description }}</p>
            <p><strong>Start Date:</strong> {{ $track->start_date->format('Y-m-d') }}</p>
            <p><strong>End Date:</strong> {{ $track->end_date->format('Y-m-d') }}</p>
        </div>
    </div>

    <h2>Sessions</h2>
    <div class="list-group mb-4">
        @forelse($track->sessions as $session)
            <a href="{{ route('admin.tracks.sessions.show', [$track->id, $session->id]) }}" class="list-group-item list-group-item-action">
                {{ $session->name }} ({{ $session->session_date->format('Y-m-d') }})
            </a>
        @empty
            <p>No sessions available for this track.</p>
        @endforelse
    </div>



    <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary">Back to List</a>
</div>
@endsection
