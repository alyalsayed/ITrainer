@extends('layouts.master')
@section('title', 'Session Details')

@section('content')
<div class="container mt-4">
    <h1>Session Details</h1>
    <a href="{{ route('sessions.index') }}" class="btn btn-primary my-3">Back to List</a>

    <table class="table table-bordered table-striped">
        <tbody>
            <tr>
                <th>Name</th>
                <td>{{ $session_data->name }}</td>
            </tr>
            <tr>
                <th>Description</th>
                <td>{{ $session_data->description }}</td>
            </tr>
            <tr>
                <th>Session Date</th>
                <td>{{ $session_data->session_date->format('F j, Y') }}</td>
            </tr>
            <tr>
                <th>Track</th>
                <td>{{ $session_data->track ? $session_data->track->name : 'N/A' }}</td>
            </tr>
            <tr>
                <th>Location</th>
                <td>{{ ucfirst($session_data->location) }}</td>
            </tr>
            <tr>
                <th>Start Time</th>
                <td>{{ \Carbon\Carbon::parse($session_data->start_time)->format('h:i A') }}</td>
            </tr>
            <tr>
                <th>End Time</th>
                <td>{{ \Carbon\Carbon::parse($session_data->end_time)->format('h:i A') }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection
