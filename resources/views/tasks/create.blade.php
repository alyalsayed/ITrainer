@extends('layouts.master')

@section('title', 'Create Task')

@section('content')
<div class="container mt-4">
    <h1>Create Task</h1>

    {{-- General error message for invalid form submission --}}
    @if ($errors->any())
        <div class="alert alert-danger">
            Please correct the errors below and try again.
        </div>
    @endif

    <form action="{{ route('tasks.store') }}" method="POST">
        @csrf

        {{-- Task Name --}}
        <div class="form-group my-3">
            <label for="name">Task Name</label>
            <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
            @if($errors->has('name'))
                <div class="text-danger">
                    {{ $errors->first('name') }}
                </div>
            @endif
        </div>

        {{-- Task Description --}}
        <div class="form-group my-3">
            <label for="description">Description</label>
            <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
            @if($errors->has('description'))
                <div class="text-danger">
                    {{ $errors->first('description') }}
                </div>
            @endif
        </div>

        {{-- Due Date --}}
        <div class="form-group my-3">
            <label for="due_date">Due Date</label>
            <input type="date" id="due_date" name="due_date" class="form-control" value="{{ old('due_date') }}" required>
            @if($errors->has('due_date'))
                <div class="text-danger">
                    {{ $errors->first('due_date') }}
                </div>
            @endif
        </div>

        {{-- Session --}}
        <div class="form-group my-3">
            <label for="session_id">Session</label>
            <select name="session_id" id="session_id" class="form-control" required>
                <option value="" disabled selected>Select a session</option>
                @foreach($sessions as $session)
                    <option value="{{ $session->id }}" {{ old('session_id') == $session->id ? 'selected' : '' }}>
                        {{ $session->name }} ({{ $session->session_date->format('F j, Y') }})
                    </option>
                @endforeach
            </select>
            @if($errors->has('session_id'))
                <div class="text-danger">
                    {{ $errors->first('session_id') }}
                </div>
            @endif
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-primary mt-3">Create Task</button>
    </form>
</div>
@endsection
