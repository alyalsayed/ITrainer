@extends('layouts.master')
@section('title', 'All Sessions')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">All Sessions</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif
       
    @if (Auth::user()->userType === 'instructor')
        <a href="{{ route('sessions.create') }}" class="btn btn-primary mb-3">Add New Session</a>
    @endif

    <table class="table table-striped table-bordered table-hover text-center">
        <thead>
            <tr>
                <th>Name</th>
                <th>Session Date</th>
                <th>Location</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($all_sessions as $session)
                <tr>
                    <td>{{ $session->name }}</td>
                    <td>{{ $session->session_date->format('F j, Y') }}</td>
                    <td>{{ ucfirst($session->location) }}</td>
                    <td class="d-flex justify-content-center align-items-center">
                        <a href="{{ route('sessions.show', $session->id) }}" class="btn btn-info btn-sm m-1" title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        
                        @if (Auth::user()->userType === 'instructor')
                            <a href="{{ route('sessions.edit', $session->id) }}" class="btn btn-warning btn-sm m-2" title="Edit">
                                <i class="fa fa-pencil"></i>
                            </a>
                            
                            <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm m-1" onclick="return confirm('Are you sure?')" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>

                      

                        @endif
       <!-- Attendance Icon -->
       <a href="{{ route('attendance.index', $session->id) }}" class="btn btn-secondary btn-sm m-1" title="Show Attendance">
        <i class="fa fa-check-square"></i>
    </a>
                        <!-- Notes Icon -->
                        <a href="{{ route('notes.index', $session->id) }}" class="btn btn-primary btn-sm m-1" title="View Notes">
                            <i class="fa fa-sticky-note"></i>
                        </a>
                           <!-- Task Icon -->
                        <a href="{{ route('sessions.tasks.index', $session->id) }}" class="btn btn-success btn-sm m-1" title="View Tasks">
                            <i class="fa fa-tasks"></i>
                        </a>

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
