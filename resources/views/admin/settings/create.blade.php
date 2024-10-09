@extends('layouts.master')

@section('title', 'Settings')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Settings Dashboard</h1>

    <div class="row">
        <!-- Personal Information -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Personal Information</h5>
                    <i class="fas fa-user-cog"></i>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.users.update', auth()->user()->id) }}" method="POST">
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
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ auth()->user()->name }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ auth()->user()->email }}">
                        </div>
                        <div class="form-group mb-3">
                            <label for="userType" class="form-label">User Type</label>
                            <select name="userType" class="form-control" id="userType" required>
                                <option value="" disabled>Select User Type</option>
                                <option value="admin" {{ auth()->user()->userType === 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="student" {{ auth()->user()->userType === 'student' ? 'selected' : '' }}>Student</option>
                                <option value="instructor" {{ auth()->user()->userType === 'instructor' ? 'selected' : '' }}>Instructor</option>
                                <option value="hr" {{ auth()->user()->userType === 'hr' ? 'selected' : '' }}>HR</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-success">Update Information</button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Change Password -->
        <div class="col-md-6">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-danger text-white d-flex justify-content-between align-items-center">
                    <h5 class="card-title mb-0">Change Password</h5>
                    <i class="fas fa-key"></i>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.password.update') }}" method="POST">
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
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="current_password" class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" id="current_password">
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" id="new_password">
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation">
                        </div>
                        <button type="submit" class="btn btn-warning">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
