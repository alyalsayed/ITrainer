@extends('layouts.master')

@section('title', 'Edit Task')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Edit Task: {{ $task->name }}</h1>

    {{-- Display success message --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Edit Task Form --}}
    <form action="{{ route('sessions.tasks.update', [$task->session_id, $task->id]) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Task Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $task->name) }}" required>
            @error('name')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="description">Description</label>
            <textarea name="description" id="description" class="form-control" rows="5" required>{{ old('description', $task->description) }}</textarea>
            @error('description')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group mt-3">
            <label for="due_date">Due Date</label>
            <input type="date" name="due_date" id="due_date" class="form-control" 
                   value="{{ old('due_date', $task->due_date->format('Y-m-d')) }}" required>
            @error('due_date')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>
        

        <button type="submit" class="btn btn-primary mt-3">Update Task</button>
    </form>

    <div class="mt-4">
        <a href="{{ route('sessions.tasks.show', [$task->session_id, $task->id]) }}" class="btn btn-secondary">Back to Task</a>
    </div>
</div>
@endsection
