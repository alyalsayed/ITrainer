@extends('layouts.master')
@section('title', 'Edit Track')
@section('content')

<div class="container">
    <h1 class="mb-4">Edit Track</h1>

    <!-- Success Message -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Validation Errors -->
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Edit Track Form -->
    <form action="{{ route('admin.tracks.update', $track->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Track Name</label>
            <input type="text" name="name" id="name" class="form-control" value="{{ old('name', $track->name) }}" required>
        </div>

        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" id="description" class="form-control" rows="4">{{ old('description', $track->description) }}</textarea>
        </div>

        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ old('start_date', $track->start_date) }}" required>
        </div>

        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ old('end_date', $track->end_date) }}" required>
        </div>

        <button type="submit" class="btn btn-primary">Update Track</button>
        <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection
