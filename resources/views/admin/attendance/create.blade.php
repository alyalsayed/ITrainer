@extends('layouts.master')

@section('title', 'Mark Attendance')

@section('content')
<div class="container py-5">
    <h1>Mark Attendance for {{ $session->name }}</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('admin.tracks.sessions.attendance.store', [$track->id, $session->id]) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">Select Student</label>
            <select name="user_id" id="user_id" class="form-select" required>
                <option value="">Choose a student...</option>
                @foreach ($students as $student)
                    <option value="{{ $student->id }}">{{ $student->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Status</label>
            <select name="status" id="status" class="form-select" required>
                <option value="present">Present</option>
                <option value="absent">Absent</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Submit Attendance</button>
        <a href="{{ route('admin.tracks.sessions.attendance.index', [$track->id, $session->id]) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
