@extends('layouts.master')
@section('title', 'Edit User')
@section('content')
<div class="container">
    <h1>Edit User</h1>
    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="name" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="name" value="{{ $user->name }}" required>
        </div>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="email" value="{{ $user->email }}" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password (Leave blank to keep current password)</label>
            <input type="password" class="form-control" name="password" id="password">
        </div>
        <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" name="password_confirmation" id="password_confirmation">
        </div>
        <div class="mb-3">
            <label for="userType" class="form-label">User Type</label>
            <select name="userType" class="form-select" required>
                <option value="admin" {{ $user->userType === 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="student" {{ $user->userType === 'student' ? 'selected' : '' }}>Student</option>
                <option value="instructor" {{ $user->userType === 'instructor' ? 'selected' : '' }}>Instructor</option>
                <option value="hr" {{ $user->userType === 'hr' ? 'selected' : '' }}>HR</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Update User</button>
        <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
