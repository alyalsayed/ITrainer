@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Create New Track</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tracks.store') }}" method="POST" id="trackForm">
                @csrf
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mb-3">
                    <label for="name" class="form-label">Track Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name') }}" placeholder="Enter track name" required>
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control"
                              rows="5" placeholder="Enter track description...">{{ old('description') }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                               class="form-control"
                               value="{{ old('start_date') }}" required>
                        @error('start_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                               class="form-control"
                               value="{{ old('end_date') }}" required>
                        @error('end_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <div class="mb-3">
                    <label for="instructor_id" class="form-label">Instructor</label>
                    <select name="instructor_id" id="instructor_id" class="form-control" required>
                        <option value="">Select Instructor</option>
                        @foreach($instructors as $instructor)
                            <option value="{{ $instructor->id }}">{{ $instructor->name }}</option>
                        @endforeach
                    </select>
                    @error('instructor_id')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <h4 class="mt-4">Sessions</h4>
                <div id="sessionContainer">
                    <div class="mb-3 session">
                        <label for="sessions[0][name]" class="form-label">Session Name</label>
                        <input type="text" name="sessions[0][name]" class="form-control" placeholder="Enter session name" required>

                        <label for="sessions[0][session_date]" class="form-label mt-2">Session Date</label>
                        <input type="date" name="sessions[0][session_date]" class="form-control" required>

                        <label for="sessions[0][start_time]" class="form-label mt-2">Start Time</label>
                        <input type="time" name="sessions[0][start_time]" class="form-control" required>

                        <label for="sessions[0][end_time]" class="form-label mt-2">End Time</label>
                        <input type="time" name="sessions[0][end_time]" class="form-control" required>

                        <label for="sessions[0][location]" class="form-label mt-2">Location</label>
                        <select name="sessions[0][location]" class="form-control" required>
                            <option value="online">Online</option>
                            <option value="offline">Offline</option>
                        </select>
                    </div>
                </div>

                <button type="button" class="btn btn-secondary mt-2" id="addSession">Add Another Session</button>
                <button type="submit" class="btn btn-primary mt-4">Create Track</button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    let sessionCount = 1; // Start from 1 since we have already added one session
    document.getElementById('addSession').addEventListener('click', function() {
        const sessionContainer = document.getElementById('sessionContainer');
        const newSession = document.createElement('div');
        newSession.className = 'mb-3 session';
        newSession.innerHTML = `
            <label for="sessions[${sessionCount}][name]" class="form-label">Session Name</label>
            <input type="text" name="sessions[${sessionCount}][name]" class="form-control" placeholder="Enter session name" required>
            <label for="sessions[${sessionCount}][session_date]" class="form-label mt-2">Session Date</label>
            <input type="date" name="sessions[${sessionCount}][session_date]" class="form-control" required>
            <label for="sessions[${sessionCount}][start_time]" class="form-label mt-2">Start Time</label>
            <input type="time" name="sessions[${sessionCount}][start_time]" class="form-control" required>
            <label for="sessions[${sessionCount}][end_time]" class="form-label mt-2">End Time</label>
            <input type="time" name="sessions[${sessionCount}][end_time]" class="form-control" required>
            <label for="sessions[${sessionCount}][location]" class="form-label mt-2">Location</label>
            <select name="sessions[${sessionCount}][location]" class="form-control" required>
                <option value="">Select Location</option>
                <option value="online">Online</option>
                <option value="offline">Offline</option>
            </select>
        `;
        sessionContainer.appendChild(newSession);
        sessionCount++; // Increment the session count
    });
</script>
@endsection

@endsection
