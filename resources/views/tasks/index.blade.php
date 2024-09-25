@extends('layouts.master')

@section('title', 'Tasks List')

@section('content')
<div class="container mt-4">
    <h1>Tasks List</h1>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Only show the "Create Task" button if the user is an instructor --}}
    @if(Auth::user()->userType == 'instructor')
        <a href="{{ route('tasks.create') }}" class="btn btn-primary mb-3">Create New Task</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Submissions</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($tasks as $task)
                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->submissions->count() }}</td>
                    <td>
                        {{-- View task details --}}
                        <a href="{{ route('tasks.show', $task->id) }}" class="btn btn-info btn-sm">View</a>

                        {{-- Only instructors can edit or delete tasks --}}
                        @if(Auth::user()->userType == 'instructor')
                            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
