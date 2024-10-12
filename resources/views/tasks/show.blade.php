@extends('layouts.master')

@section('title', 'Task Details')

@section('content')



<div class="container mt-4">
    <h1 class="mb-4">Task Details for Task: {{ $task->name }}</h1>
 {{-- Success Message --}}
 @if (session('success'))
 <div class="alert alert-success">
     {{ session('success') }}
 </div>
@endif

    <a href="{{ route('sessions.tasks.index', $task->session_id) }}" class="btn btn-primary">Back</a>

    {{-- Task details --}}
    <table class="table table-bordered table-striped text-center my-4">
        <thead>
            <tr>
                <th>Task Name</th>
                <th>Description</th>
                <th>Due Date</th>
                @if(Auth::user()->userType == 'instructor')
                <th>Submissions</th>
                @endif
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>{{ $task->name }}</td>
                <td>{{ $task->description }}</td>
                <td>{{ $task->due_date }}</td>
                @if(Auth::user()->userType == 'instructor')
                <td>{{ $task->submissions->count() }}</td>
                @endif
                
            </tr>
        </tbody>
    </table>

    {{-- Task submissions (for instructors) --}}
    @if(Auth::user()->userType == 'instructor')
        <h3>Submissions</h3>
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
                            <td>
                                @if($submission->submission_type == 'link')
                                    <a href="{{ $submission->submission }}" target="_blank" class="btn btn-sm btn-info">Visit Link</a>
                                @else
                                    <a href="{{ asset('storage/' .$submission->submission) }}" download class="btn btn-sm btn-info">Download</a>
                                @endif
                            </td>
                            <td>{{ ucfirst($submission->status) }}</td>
                            <td>{{ $submission->grade ?? 'Not graded' }}</td>
                            <td>
                                {{-- Action buttons for grading --}}
                                <a href="{{ route('sessions.tasks.grade.form', [$submission->task->session_id, $submission->task_id, $submission->id]) }}" class="btn btn-sm btn-primary">Grade</a>
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
            <form action="{{ route('sessions.tasks.submit', [$task->session_id, $task->id]) }}" method="POST" enctype="multipart/form-data" id="submissionForm">
                @csrf
                <div class="form-group">
                    <label for="submission_type">Submission Type</label>
                    <select name="submission_type" id="submission_type" class="form-control" onchange="handleSubmissionTypeChange()">
                        <option value="" selected>Select Type</option>
                        <option value="file">File</option>
                        <option value="link">Link</option>
                    </select>
                </div>

                <div id="submissionInputContainer" class="mt-3">
                    
                    <div id="submissionInput"></div>
                    @error('submission')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
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
            <a href="{{ route('sessions.tasks.edit', [$task->session_id, $task->id]) }}" class="btn btn-warning">Edit Task</a>

            <form action="{{ route('sessions.tasks.destroy', [$task->session_id, $task->id]) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">Delete Task</button>
            </form>
        </div>
    @endif
</div>

<script>
    function handleSubmissionTypeChange() {
        const submissionType = document.getElementById('submission_type').value;
        const submissionInputContainer = document.getElementById('submissionInput');

        // Clear previous input
        submissionInputContainer.innerHTML = '<label for="submission">Submission</label>';

        // Create new input element based on submission type
        if (submissionType === 'file') {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.name = 'submission';
            fileInput.id = 'submission_file';
            fileInput.classList.add('form-control');
            submissionInputContainer.appendChild(fileInput);
        } else {
            const linkInput = document.createElement('input');
            linkInput.type = 'text';
            linkInput.name = 'submission';
            linkInput.id = 'submission_link';
            linkInput.classList.add('form-control');
            linkInput.placeholder = 'Enter submission link';
            submissionInputContainer.appendChild(linkInput);
        }
    }
</script>
@endsection
