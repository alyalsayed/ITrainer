@extends('layouts.master')
@section('title', 'Create Track')
@section('content')

<div class="container">
    <h1>Create New Track</h1>

    <form action="{{ route('admin.tracks.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Track Name</label>
            <input type="text" class="form-control" name="name" id="name" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea class="form-control" name="description" id="description"></textarea>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" class="form-control" name="start_date" id="start_date" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" class="form-control" name="end_date" id="end_date" required>
        </div>

        <button type="submit" class="btn btn-primary">Create Track</button>
        <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection
