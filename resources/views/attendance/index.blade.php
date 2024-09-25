@extends('layouts.master')
@section('title', 'Attendance')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Session Attendance</h1>
    <h3 class="mb-4"> Session title: {{ $session->name }}</h3>

    {{-- add button back to sessions --}}
    <a href="{{ route('sessions.index')}}" class="btn btn-primary mb-3">Back to Sessions</a>
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if(Auth::user()->userType === 'instructor')
        <form action="{{ route('attendance.store', $session->id) }}" method="POST">
            @csrf

            <table class="table table-striped table-bordered table-hover text-center">
                <thead>
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
                                <input type="checkbox" name="attendance[]" value="{{ $student->id }}"
                                    {{ isset($attendanceRecords[$student->id]) && $attendanceRecords[$student->id]->status == 'present' ? 'checked' : '' }}>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <button type="submit" class="btn btn-primary">Submit Attendance</button>
        </form>
    @else
        <p>You are not authorized to access this page.</p>
    @endif
</div>
@endsection
