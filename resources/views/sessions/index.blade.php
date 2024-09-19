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
                        <a href="{{ route('sessions.show', $session->id) }}" class="btn btn-info btn-sm" title="View">
                            <i class="fa fa-eye"></i>
                        </a>
                        @if (Auth::user()->userType === 'instructor')
                        <a href="{{ route('sessions.edit', $session->id) }}" class="btn btn-warning btn-sm m-2" title="Edit">
                            <i class="fa fa-pencil"></i>
                        </a>
                        <form action="{{ route('sessions.destroy', $session->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')" title="Delete">
                                <i class="fa fa-trash"></i>
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
