@extends('layouts.master')

@section('title', 'Task Details')

@section('content')
<div class="container mt-4">
    <h1>Task Details for Task: {{ $task->name }}</h1>

    {{-- Task details --}}
    <table class="table table-bordered table-striped text-center my-4">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Due Date</th>
                <th>Submissions</th>
                
            </tr>
        </thead>
        <tbody>
                <tr>
                    <td>{{ $task->name }}</td>
                    <td>{{ $task->description }}</td>
                    <td>{{ $task->due_date }}</td>
                    <td>{{ $task->submissions->count() }}</td>
                </tr>


    {{-- Task submissions (for instructors) --}}
    @if(Auth::user()->userType == 'instructor')
        @if($submissions->isEmpty())
            <p>No submissions yet.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Student Name</th>
                        <th>Submission Type</th>
                        <th>Submission</th>
                        <th>Status</th>
                        <th>Grade</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($submissions as $submission)
                        <tr>
                            <td>{{ $submission->user->name }}</td>
                            <td>{{ ucfirst($submission->submission_type) }}</td>
                            <td>{{ $submission->submission }}</td>
                            <td>{{ ucfirst($submission->status) }}</td>
                            <td>{{ $submission->grade ?? 'Not graded' }}</td>
                            <td>
                                {{-- Add grade/feedback form --}}
                                <a href="#" class="btn btn-sm btn-primary">Grade</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @endif

    {{-- Submit task form (for students) --}}
    @if(Auth::user()->userType == 'student')
        <h3>Submit Task</h3>
        @if($submissions->where('student_id', Auth::user()->id)->isEmpty())
            <form action="{{ route('tasks.submit', $task->id) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="submission_type">Submission Type</label>
                    <select name="submission_type" id="submission_type" class="form-control">
                        <option value="file">File</option>
                        <option value="link">Link</option>
                    </select>
                </div>

                <div class="form-group mt-3">
                    <label for="submission">Submission</label>
                    <input type="text" name="submission" id="submission" class="form-control" placeholder="Enter submission (link or file path)">
                </div>

                <button type="submit" class="btn btn-success mt-3">Submit Task</button>
            </form>
        @else
            <p>You have already submitted this task.</p>
        @endif
    @endif

    {{-- Edit/Delete options for instructors --}}
    @if(Auth::user()->userType == 'instructor')
        <div class="mt-4">
            <a href="{{ route('tasks.edit', $task->id) }}" class="btn btn-warning">Edit Task</a>

            <form action="{{ route('tasks.destroy', $task->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Task</button>
            </form>
        </div>
    @endif
</div>
@endsection
