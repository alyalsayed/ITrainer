@extends('layouts.master')

@section('title', 'Tracks')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Tracks</h1>

    <!-- Button for Adding a New Track with Hover Animation -->
    <div class="mb-4 d-flex justify-content-center">
        <a href="{{ route('admin.tracks.create') }}" class="btn btn-lg add-track-btn">
            <i class="fas fa-plus"></i> Add New Track
        </a>
    </div>

    @if ($tracks->isEmpty())
        <div class="alert alert-info text-center">
            <img src="{{ asset('images/empty-state.svg') }}" alt="No tracks" class="img-fluid mb-3" style="width: 150px;">
            <p>There are no tracks added yet. Please add a new track.</p>
        </div>
    @else
        <div class="row">
            @foreach ($tracks as $track)
                <div class="col-md-4 mb-4">
                    <div class="card track-card shadow-sm">
                        <div class="card-body">
                            <h5 class="card-title">{{ $track->name }}</h5>
                            <p class="card-text">{{ Str::limit($track->description, 100) }}</p>
                            <p class="card-text">
                                <small class="text-muted">Start: {{ $track->start_date->format('Y-m-d') }} | End: {{ $track->end_date->format('Y-m-d') }}</small>
                            </p>

                            <div class="d-flex justify-content-around">
                                <!-- Action Buttons with Icons and Tooltips -->
                                <a href="{{ route('admin.tracks.show', $track->id) }}" class="btn btn-sm btn-info action-btn show-btn mx-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Show">
                                    <i class="fas fa-eye"></i> Show
                                </a>

                                <button class="btn btn-sm btn-warning action-btn edit-btn mx-1" data-bs-toggle="modal" data-bs-target="#editTrackModal-{{ $track->id }}" data-bs-toggle="tooltip" data-bs-placement="top" title="Edit">
                                    <i class="fas fa-edit"></i> Edit
                                </button>

                                <form action="{{ route('admin.tracks.destroy', $track->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this track?');">
                                    @csrf
                                    @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endif
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger action-btn delete-btn mx-1" data-bs-toggle="tooltip" data-bs-placement="top" title="Delete">
                                        <i class="fas fa-trash"></i> Delete
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

<!-- Modal for Editing Track -->
<div class="modal fade" id="editTrackModal-{{ $track->id }}" tabindex="-1" aria-labelledby="editTrackLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Track</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('admin.tracks.update', $track->id) }}" method="POST">
                    @csrf
                    @method('PUT')

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="mb-3">
                        <label for="name-{{ $track->id }}" class="form-label">Track Name</label>
                        <input type="text" class="form-control" id="name-{{ $track->id }}" name="name" value="{{ old('name', $track->name) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="description-{{ $track->id }}" class="form-label">Description</label>
                        <textarea class="form-control" id="description-{{ $track->id }}" name="description">{{ old('description', $track->description) }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label for="start_date-{{ $track->id }}" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date-{{ $track->id }}" name="start_date" value="{{ old('start_date', $track->start_date->format('Y-m-d')) }}" required>
                    </div>

                    <div class="mb-3">
                        <label for="end_date-{{ $track->id }}" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date-{{ $track->id }}" name="end_date" value="{{ old('end_date', $track->end_date->format('Y-m-d')) }}" required>
                    </div>

                    <!-- Add Instructor Selection -->
                    <div class="mb-3">
                        <label for="instructor_id" class="form-label">Instructor</label>
                        <select class="form-select" id="instructor_id" name="instructor_id" required>
                            <option value="">Select an instructor</option>
                            @foreach ($instructors as $instructor)
                                <option value="{{ $instructor->id }}" {{ (old('instructor_id', $track->instructor_id) == $instructor->id) ? 'selected' : '' }}>
                                    {{ $instructor->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <h4 class="mt-4">Sessions</h4>
                    <div id="sessionContainer-{{ $track->id }}">
                        @foreach($track->sessions as $session)
                            <div class="mb-3 session">
                                <label for="sessions[{{ $session->id }}][name]" class="form-label">Session Name</label>
                                <input type="text" name="sessions[{{ $session->id }}][name]" class="form-control"
                                       value="{{ old('sessions.' . $session->id . '.name', $session->name) }}" required>

                                <label for="sessions[{{ $session->id }}][session_date]" class="form-label mt-2">Session Date</label>
                                <input type="date" name="sessions[{{ $session->id }}][session_date]" class="form-control"
                                       value="{{ old('sessions.' . $session->id . '.session_date', $session->session_date->format('Y-m-d')) }}" required>

                                <label for="sessions[{{ $session->id }}][start_time]" class="form-label mt-2">Start Time</label>
                                <input type="time" name="sessions[{{ $session->id }}][start_time]" class="form-control"
                                       value="{{ old('sessions.' . $session->id . '.start_time', $session->start_time) }}" required>

                                <label for="sessions[{{ $session->id }}][end_time]" class="form-label mt-2">End Time</label>
                                <input type="time" name="sessions[{{ $session->id }}][end_time]" class="form-control"
                                       value="{{ old('sessions.' . $session->id . '.end_time', $session->end_time) }}" required>

                                <label for="sessions[{{ $session->id }}][location]" class="form-label mt-2">Location</label>
                                <select name="sessions[{{ $session->id }}][location]" class="form-control" required>
                                    <option value="online" {{ (old('sessions.' . $session->id . '.location', $session->location) == 'online') ? 'selected' : '' }}>Online</option>
                                    <option value="offline" {{ (old('sessions.' . $session->id . '.location', $session->location) == 'offline') ? 'selected' : '' }}>Offline</option>
                                </select>
                            </div>
                        @endforeach
                    </div>

                    <button type="button" class="btn btn-secondary" id="addSession-{{ $track->id }}">Add Another Session</button>
                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-4">
            {{ $tracks->links() }}
        </div>
    @endif

    @if (Auth::user() && Auth::user()->userType === 'admin')
        <!-- Content for tracks if the user is an admin -->
    @else
        <div class="alert alert-danger text-center">
            <p>You do not have permission to view this page.</p>
        </div>
    @endif
</div>

<!-- Custom Styles -->
<style>
    /* Add New Track Button */
    .add-track-btn {
        background-color: #1abc9c;
        border: none;
        color: white;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    .add-track-btn:hover {
        background-color: #16a085;
        transform: scale(0.98);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }

    /* Track Cards */
    .track-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 10px;
        padding: 15px;
    }

    .track-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    /* Action Buttons with Icons */
    .action-btn {
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
        transition: all 0.3s ease;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        padding: 5px 10px;
        width: 100px; /* Adjust based on your preference */
    }

    /* Icon and text spacing */
    .action-btn i {
        margin-right: 5px;
    }

    /* Specific Button Colors */
    .show-btn {
        background-color: #3498db;
        color: white;
    }

    .show-btn:hover {
        background-color: #2980b9;
    }

    .edit-btn {
        background-color: #f1c40f;
        color: white;
    }

    .edit-btn:hover {
        background-color: #f39c12;
    }

    .delete-btn {
        background-color: #e74c3c;
        color: white;
    }

    .delete-btn:hover {
        background-color: #c0392b;
    }

    /* Tooltip Styling */
    .tooltip-inner {
        background-color: #333;
        color: #fff;
        font-size: 12px;
        padding: 5px;
    }

    /* Pagination */
    .pagination {
        justify-content: center;
    }

    /* Modal Styling */
    .modal-header {
        background-color: #f8f9fa;
        border-bottom: none;
    }

    .modal-title {
        color: #343a40;
    }

    .modal-body {
        padding: 20px;
    }
</style>

<!-- Bootstrap JS and Tooltip Initialization -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl);
    });

    // Add Session Functionality
    document.querySelectorAll('[id^="addSession-"]').forEach(button => {
        button.addEventListener('click', function() {
            let trackId = this.id.split('-')[1];
            let sessionContainer = document.getElementById(`sessionContainer-${trackId}`);

            // Create new session elements
            let newSessionIndex = sessionContainer.children.length + 1; // Adjust index accordingly
            let newSession = `
                <div class="mb-3 session">
                    <label for="sessions[new_${newSessionIndex}][name]" class="form-label">Session Name</label>
                    <input type="text" name="sessions[new_${newSessionIndex}][name]" class="form-control" required>

                    <label for="sessions[new_${newSessionIndex}][session_date]" class="form-label mt-2">Session Date</label>
                    <input type="date" name="sessions[new_${newSessionIndex}][session_date]" class="form-control" required>

                    <label for="sessions[new_${newSessionIndex}][start_time]" class="form-label mt-2">Start Time</label>
                    <input type="time" name="sessions[new_${newSessionIndex}][start_time]" class="form-control" required>

                    <label for="sessions[new_${newSessionIndex}][end_time]" class="form-label mt-2">End Time</label>
                    <input type="time" name="sessions[new_${newSessionIndex}][end_time]" class="form-control" required>

                    <label for="sessions[new_${newSessionIndex}][location]" class="form-label mt-2">Location</label>
                    <select name="sessions[new_${newSessionIndex}][location]" class="form-control" required>
                        <option value="online">Online</option>
                        <option value="offline">Offline</option>
                    </select>
                </div>
            `;

            sessionContainer.insertAdjacentHTML('beforeend', newSession);
        });
    });
</script>
@endsection
