@extends('layouts.master')
@section('title', 'Attendance')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Session Attendance</h1>
    <h3 class="mb-4">Session Title: {{ $session->name }}</h3>

    {{-- Button to go back to sessions --}}
    <a href="{{ route('sessions.index') }}" class="btn btn-primary mb-3">Back to Sessions</a>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(Auth::user()->userType === 'student')
        <h4 class="mb-4">Your Attendance Status</h4>
        <div class="card mb-4">
            <div class="card-body">
                <p class="mb-1"><strong>Status:</strong> {{ $attendanceRecord ? $attendanceRecord->status : 'Not marked' }}</p>
                <p class="mb-1"><strong>Session Date:</strong> {{ \Carbon\Carbon::parse($session->session_date)->format('l, F j, Y') }}</p>
                <p class="mb-1"><strong>Track:</strong> {{ $session->track->name }}</p>
                <p class="mb-1"><strong>Description:</strong> {{ $session->description ?? 'N/A' }}</p>
            </div>
        </div>
    @else
        @if(Auth::user()->userType === 'instructor')
            <h4 class="mb-4">Mark Attendance</h4>
            <form action="{{ route('attendance.store', $session->id) }}" method="POST">
                @csrf

                <div class="table-responsive">
                    <table class="table table-striped table-bordered table-hover text-center">
                        <thead class="thead-dark">
                            <tr>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Present</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $student)
                                <tr>
                                    <td>{{ $student->name }}</td>
                                    <td>{{ $student->email }}</td>
                                    <td>
                                        <input type="checkbox" name="attendance[]"
                                            value="{{ $student->id }}"
                                            {{ isset($attendanceRecords[$student->id]) && $attendanceRecords[$student->id]->status == 'present' ? 'checked' : '' }}>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <button type="submit" class="btn btn-primary">Submit Attendance</button>
            </form>
        @else
            <p>You are not authorized to access this page.</p>
        @endif
    @endif
</div>
@endsection
