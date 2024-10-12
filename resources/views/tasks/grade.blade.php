@extends('layouts.master')

@section('title', 'Grade Task Submission')

@section('content')
<div class="container mt-4">
    <h1 class="mb-4">Grade Task Submission for: {{ $submission->user->name }}</h1>

    <div class="mb-4">
        <h5>Student Information</h5>
        <div class="card">
            <div class="card-body">
                <h6 class="card-title">Name: {{ $submission->user->name }}</h6>
                <p class="card-text"><strong>Email:</strong> {{ $submission->user->email }}</p>
                <p class="card-text"><strong>Submission Type:</strong> {{ ucfirst($submission->submission_type) }}</p>
                <p class="card-text"><strong>Submission:</strong>
                    @if($submission->submission_type === 'link')
                        <a href="{{ $submission->submission }}" target="_blank">{{ $submission->submission }}</a>
                    @else
                        <a href="{{ asset('storage/' . $submission->submission) }}" download>Download Submission</a>
                    @endif
                </p>
            </div>
        </div>
    </div>

    {{-- Grading Form --}}
    <form action="{{ route('sessions.tasks.grade', [$submission->task->session_id, $submission->task_id, $submission->id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="grade">Grade</label>
            <input type="number" name="grade" id="grade" class="form-control" min="0" max="10" step="0.5" value="{{ old('grade', $submission->grade) }}" required>
            <small class="form-text text-muted">Grade from 0 to 10.</small>
        </div>

        <div class="form-group mt-3">
            <label for="feedback">Feedback</label>
            <textarea name="feedback" id="feedback" class="form-control" rows="5">{{ old('feedback', $submission->feedback) }}</textarea>
        </div>

        <button type="submit" class="btn btn-success mt-3">Submit Grade</button>
    </form>

    {{-- Error handling --}}
    @if ($errors->any())
        <div class="alert alert-danger mt-3">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="mt-4">
        <a href="{{ route('sessions.tasks.show', [$submission->task->session_id, $submission->task_id]) }}" class="btn btn-primary">Back to Task</a>
    </div>
</div>
@endsection
