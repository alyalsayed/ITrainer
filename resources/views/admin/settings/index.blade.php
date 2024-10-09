@extends('layouts.master')

@section('title', 'Settings')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Settings</h1>

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
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name', auth()->user()->name) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email', auth()->user()->email) }}" required>
                        </div>
                        <!-- User Type Field -->
                        <div class="form-group mb-3">
                            <label for="userType" class="form-label">User Type</label>
                            <select name="userType" class="form-select" id="userType" required>
                                <option value="">Select User Type</option>
                                @foreach (\App\Models\User::USER_TYPES as $userType)
                                    <option value="{{ $userType }}" {{ auth()->user()->userType === $userType ? 'selected' : '' }}>
                                        {{ ucfirst($userType) }}
                                    </option>
                                @endforeach
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
                            <input type="password" name="current_password" class="form-control" id="current_password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password" class="form-label">New Password</label>
                            <input type="password" name="new_password" class="form-control" id="new_password" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirm New Password</label>
                            <input type="password" name="new_password_confirmation" class="form-control" id="new_password_confirmation" required>
                        </div>
                        <button type="submit" class="btn btn-warning">Update Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Settings Management -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="card-title mb-0">Manage Settings</h5>
                </div>
                <div class="card-body">
                    @foreach ($settings as $setting)
                        <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-3">
                                <label for="setting-{{ $setting->id }}" class="form-label">{{ $setting->key }}</label>
                                <input type="text" name="value" class="form-control" id="setting-{{ $setting->id }}" value="{{ $setting->value }}" required>
                            </div>
                            <button type="submit" class="btn btn-primary mb-3">Update {{ $setting->key }}</button>
                        </form>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
