@extends('layouts.master')
@section('title', 'Tracks')
@section('content')

<div class="container">
    <h1 class="mb-4">All Tracks</h1>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <a href="{{ route('admin.tracks.create') }}" class="btn btn-primary mb-3">Create New Track</a>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($tracks as $track)
                <tr>
                    <td>{{ $track->id }}</td>
                    <td>{{ $track->name }}</td>
                    <td>{{ $track->start_date }}</td>
                    <td>{{ $track->end_date }}</td>
                    <td>
                        <a href="{{ route('admin.tracks.edit', $track->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <a href="{{ route('admin.tracks.assign', $track->id) }}" class="btn btn-info btn-sm my-2 ">Assign Users</a>
                        <form action="{{ route('admin.tracks.destroy', $track->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection
