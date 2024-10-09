@extends('layouts.master')

@section('content')
<div class="container">
    <h1>Attendance for {{ $session->name }}</h1>
    <table class="table">
        <thead>
            <tr>
                <th>User</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($attendance as $record)
                <tr>
                    <td>
                        @if($record->student) <!-- Check if the student relationship exists -->
                            {{ $record->student->name }} <!-- Use student instead of user -->
                        @else
                            N/A <!-- Fallback value if student does not exist -->
                        @endif
                    </td>
                    <td>{{ ucfirst($record->status) }}</td>
                    <td>
                        <form action="{{ route('admin.tracks.sessions.attendance.destroy', [$track->id, $session->id, $record->id]) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this record?');">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @if (Auth::user()->userType === 'admin')
        <a href="{{ route('admin.tracks.sessions.attendance.create', [$track->id, $session->id]) }}" class="btn btn-primary">Mark Attendance</a>
    @endif
</div>
@endsection
