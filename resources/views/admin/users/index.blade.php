@extends('layouts.master')
@section('title', 'All Users')
@section('content')

<div class="container">
    <h1 class="mb-4">All Users</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <a href="{{ route('admin.users.create') }}" class="btn btn-primary mb-3">Create New User</a>

    <!-- Filter and Search Form -->
    <form action="{{ route('admin.users.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <div class="dropdown">
                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ request('userType') ? ucfirst(request('userType')) : 'All User Types' }}
                    </button>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="{{ route('admin.users.index', ['userType' => 'admin']) }}">Admin</a>
                        <a class="dropdown-item" href="{{ route('admin.users.index', ['userType' => 'student']) }}">Student</a>
                        <a class="dropdown-item" href="{{ route('admin.users.index', ['userType' => 'instructor']) }}">Instructor</a>
                        <a class="dropdown-item" href="{{ route('admin.users.index', ['userType' => 'hr']) }}">HR</a>
                        <a class="dropdown-item" href="{{ route('admin.users.index') }}">All User Types</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <input type="text" name="search" class="form-control" placeholder="Search by name" value="{{ request('search') }}">
            </div>
            <div class="col-md-4">
                <button type="submit" class="btn btn-secondary">Filter</button>
            </div>
        </div>
    </form>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>User Type</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($users as $user)
                <tr>
                    <td>{{ $user->id }}</td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>{{ ucfirst($user->userType) }}</td>
                    <td>
                        <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Custom Pagination -->
    <nav aria-label="...">
        <ul class="pagination">
            @if ($users->onFirstPage())
                <li class="page-item disabled">
                    <a class="page-link" href="#" tabindex="-1">Previous</a>
                </li>
            @else
                <li class="page-item">
                    <a class="page-link" href="{{ $users->previousPageUrl() }}">Previous</a>
                </li>
            @endif

            @for ($i = 1; $i <= $users->lastPage(); $i++)
                <li class="page-item {{ ($users->currentPage() == $i) ? 'active' : '' }}">
                    <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                </li>
            @endfor

            @if ($users->hasMorePages())
                <li class="page-item">
                    <a class="page-link" href="{{ $users->nextPageUrl() }}">Next</a>
                </li>
            @else
                <li class="page-item disabled">
                    <a class="page-link" href="#">Next</a>
                </li>
            @endif
        </ul>
    </nav>
</div>

@endsection
