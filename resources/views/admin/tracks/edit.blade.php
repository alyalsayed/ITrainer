@extends('layouts.master')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm">
        <div class="card-header">
            <h2>Edit Track: {{ $track->name }}</h2>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.tracks.update', $track->id) }}" method="POST">
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

                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Track Name</label>
                    <input type="text" name="name" id="name" class="form-control"
                           value="{{ old('name', $track->name) }}"
                           placeholder="Enter the track name">
                    @error('name')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description"
                              class="form-control" rows="5" placeholder="Enter track description...">{{ old('description', $track->description) }}</textarea>
                    @error('description')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>

                <div class="row">
                    <div class="col-md-6 mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" name="start_date" id="start_date"
                               class="form-control"
                               value="{{ old('start_date', $track->start_date->format('Y-m-d')) }}">
                        @error('start_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="col-md-6 mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" name="end_date" id="end_date"
                               class="form-control"
                               value="{{ old('end_date', $track->end_date->format('Y-m-d')) }}">
                        @error('end_date')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <h4 class="mt-4">Sessions</h4>
                <div id="sessionContainer">
                    @foreach($track->sessions as $session)
                        <div class="mb-3 session">
                            <label for="sessions[{{ $session->id }}][name]" class="form-label">Session Name</label>
                            <input type="text" name="sessions[{{ $session->id }}][name]" class="form-control"
                                   value="{{ old('sessions.' . $session->id . '.name', $session->name) }}">

                            <label for="sessions[{{ $session->id }}][session_date]" class="form-label mt-2">Session Date</label>
                            <input type="date" name="sessions[{{ $session->id }}][session_date]" class="form-control"
                                   value="{{ old('sessions.' . $session->id . '.session_date', $session->session_date) }}">

                            <label for="sessions[{{ $session->id }}][start_time]" class="form-label mt-2">Start Time</label>
                            <input type="time" name="sessions[{{ $session->id }}][start_time]" class="form-control"
                                   value="{{ old('sessions.' . $session->id . '.start_time', $session->start_time) }}">

                            <label for="sessions[{{ $session->id }}][end_time]" class="form-label mt-2">End Time</label>
                            <input type="time" name="sessions[{{ $session->id }}][end_time]" class="form-control"
                                   value="{{ old('sessions.' . $session->id . '.end_time', $session->end_time) }}">

                            <label for="sessions[{{ $session->id }}][location]" class="form-label mt-2">Location</label>
                            <select name="sessions[{{ $session->id }}][location]" class="form-control">
                                <option value="online" {{ (old('sessions.' . $session->id . '.location', $session->location) == 'online') ? 'selected' : '' }}>Online</option>
                                <option value="offline" {{ (old('sessions.' . $session->id . '.location', $session->location) == 'offline') ? 'selected' : '' }}>Offline</option>
                            </select>
                        </div>
                    @endforeach
                </div>

                <button type="button" class="btn btn-secondary" id="addSession">Add Another Session</button>
                <button type="submit" class="btn btn-primary mt-4">Update Track</button>
            </form>
        </div>
    </div>
</div>

@section('scripts')
<script>
    document.getElementById('addSession').addEventListener('click', function() {
        const sessionContainer = document.getElementById('sessionContainer');
        const newSession = document.createElement('div');
        newSession.className = 'mb-3 session';
        newSession.innerHTML = `
            <label class="form-label">Session Name</label>
            <input type="text" name="sessions[][name]" class="form-control" placeholder="Enter session name">

            <label class="form-label mt-2">Session Date</label>
            <input type="date" name="sessions[][session_date]" class="form-control">

            <label class="form-label mt-2">Start Time</label>
            <input type="time" name="sessions[][start_time]" class="form-control">

            <label class="form-label mt-2">End Time</label>
            <input type="time" name="sessions[][end_time]" class="form-control">

            <label class="form-label mt-2">Location</label>
            <select name="sessions[][location]" class="form-control">
                <option value="online">Online</option>
                <option value="offline">Offline</option>
            </select>
        `;
        sessionContainer.appendChild(newSession);
    });
</script>
@endsection

@endsection
