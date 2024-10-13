@extends('layouts.master')

@section('title', 'Tasks List')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Tasks List for Session : {{ $session->name }}</h1>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Only show the "Create Task" button if the user is an instructor --}}
    @if(Auth::user()->userType == 'instructor')
        <a href="{{ route('sessions.tasks.create', $sessionId) }}" class="btn btn-primary mb-3">Create New Task</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Due Date</th>
                @if(Auth::user()->userType == 'instructor')
                <th>Submissions</th>
                @endif
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->due_date }}</td>
                    @if(Auth::user()->userType == 'instructor')
                    <td>{{ $task->submissions->count() }}</td>
                    @endif
                    <td>
                        {{-- View task details --}}
                        <a href="{{ route('sessions.tasks.show', [$sessionId, $task->id]) }}" class="btn btn-info btn-sm m-1">

                            @if(Auth::user()->userType == 'instructor')
                                Details
                            @else
                                Submit
                            @endif

                        </a>

                        {{-- Only instructors can edit or delete tasks --}}
                        @if(Auth::user()->userType == 'instructor')
                            <a href="{{ route('sessions.tasks.edit', [$sessionId, $task->id]) }}" class="btn btn-warning btn-sm m-1">Edit</a>
                            <form action="{{ route('sessions.tasks.destroy', [$sessionId, $task->id]) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm m-1">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
