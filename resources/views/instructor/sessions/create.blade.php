@extends('layouts.master')
@section('title', 'Create Session')

@section('content')
<div class="container mt-4">
    <h1>Create Session</h1>

    {{-- General error message for invalid form submission --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            Please fill the fields correctly.
        </div>
    @endif

    <form action="{{ route('sessions.store') }}" method="POST">
        @csrf
        {{-- Session Name --}}
        <div class="form-group">
            <label for="name">Session Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            @if($errors->has('name'))
                <div class="text-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>

        {{-- Track --}}
        <div class="form-group">
            <label for="track_id">Track</label>
            <select id="track_id" name="track_id" class="form-control" required>
                @foreach($tracks as $track)
                    <option value="{{ $track->id }}" {{ old('track_id') == $track->id ? 'selected' : '' }}>
                        {{ $track->name }}
                    </option>
                @endforeach
            </select>
            @if($errors->has('track_id'))
                <div class="text-danger">
                    {{ $errors->first('track_id') }}
                </div>
            @endif
        </div>

        {{-- Session Date --}}
        <div class="form-group">
            <label for="session_date">Session Date</label>
            <input type="date" id="session_date" name="session_date" class="form-control" value="{{ old('session_date') }}" required>
            @if($errors->has('session_date'))
                <div class="text-danger">
                    {{ $errors->first('session_date') }}
                </div>
            @endif
        </div>

        {{-- Start Time --}}
        <div class="form-group">
            <label for="start_time">Start Time</label>
            <input type="time" id="start_time" name="start_time" class="form-control" value="{{ old('start_time') }}" required>
            @if($errors->has('start_time'))
                <div class="text-danger">
                    {{ $errors->first('start_time') }}
                </div>
            @endif
        </div>

        {{-- End Time --}}
        <div class="form-group">
            <label for="end_time">End Time</label>
            <input type="time" id="end_time" name="end_time" class="form-control" value="{{ old('end_time') }}" required>
            @if($errors->has('end_time'))
                <div class="text-danger">
                    {{ $errors->first('end_time') }}
                </div>
            @endif
        </div>

        {{-- Description --}}
        <div class="form-group">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control">{{ old('description') }}</textarea>
            @if($errors->has('description'))
                <div class="text-danger">
                    {{ $errors->first('description') }}
                </div>
            @endif
        </div>

        {{-- Location --}}
        <div class="form-group">
            <label for="location">Location</label>
            <select id="location" name="location" class="form-control">
                <option value="online" {{ old('location') == 'online' ? 'selected' : '' }}>Online</option>
                <option value="offline" {{ old('location') == 'offline' ? 'selected' : '' }}>Offline</option>
            </select>
            @if($errors->has('location'))
                <div class="text-danger">
                    {{ $errors->first('location') }}
                </div>
            @endif
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary">Create Session</button>
    </form>
</div>
@endsection
