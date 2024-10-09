@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container-fluid">
    <h1 class="mt-4 mb-4 text-center">Welcome to the Home Page</h1>

    <div class="row mt-4">
        <!-- Students Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ url('/admin/users/table?type=student') }}" class="card border-left-primary shadow-lg h-100 py-2">
                <div class="card-body text-center">
                    <div class="h3 card-title">{{ $studentCount }}</div>
                    <p class="text-xs font-weight-bold text-primary text-uppercase mb-1">Students</p>
                </div>
                <div class="card-footer text-center bg-primary">
                    <span class="text-white font-weight-bold">View Details</span>
                </div>
            </a>
        </div>

        <!-- Instructors Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ url('/admin/users/table?type=instructor') }}" class="card border-left-success shadow-lg h-100 py-2">
                <div class="card-body text-center">
                    <div class="h3 card-title">{{ $instructorCount }}</div>
                    <p class="text-xs font-weight-bold text-success text-uppercase mb-1">Instructors</p>
                </div>
                <div class="card-footer text-center bg-success">
                    <span class="text-white font-weight-bold">View Details</span>
                </div>
            </a>
        </div>

        <!-- Admins Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ url('/admin/users/table?type=admin') }}" class="card border-left-danger shadow-lg h-100 py-2">
                <div class="card-body text-center">
                    <div class="h3 card-title">{{ $adminCount }}</div>
                    <p class="text-xs font-weight-bold text-danger text-uppercase mb-1">Admins</p>
                </div>
                <div class="card-footer text-center bg-danger">
                    <span class="text-white font-weight-bold">View Details</span>
                </div>
            </a>
        </div>

        <!-- HR Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <a href="{{ url('/admin/users/table?type=hr') }}" class="card border-left-info shadow-lg h-100 py-2">
                <div class="card-body text-center">
                    <div class="h3 card-title">{{ $hrCount }}</div>
                    <p class="text-xs font-weight-bold text-info text-uppercase mb-1">HR</p>
                </div>
                <div class="card-footer text-center bg-info">
                    <span class="text-white font-weight-bold">View Details</span>
                </div>
            </a>
        </div>
    </div>

    <!-- Quick Links Section -->
    <div class="row mt-5">
        <div class="col-lg-4 mb-3">
            <a href="{{ route('admin.users.index') }}" class="btn btn-primary btn-lg btn-block shadow-lg">Manage Users</a>
        </div>
        <div class="col-lg-4 mb-3">
            <a href="{{ route('admin.tracks.index') }}" class="btn btn-secondary btn-lg btn-block shadow-lg">Manage Tracks</a>
        </div>
        <div class="col-lg-4 mb-3">
            <a href="{{ route('admin.settings.index') }}" class="btn btn-success btn-lg btn-block shadow-lg">Manage Settings</a>
        </div>
    </div>

    <!-- Additional Information Section -->
    <div class="row mt-5">
        <div class="col-lg-12">
            <div class="alert alert-info text-center shadow-sm">
                <strong>Quick Tips:</strong> Use the navigation above to access various functionalities. Ensure all data is kept up to date for optimal performance.
            </div>
        </div>
    </div>

    <!-- Recent Activities Section -->
    <div class="row mt-5">
        <div class="col-lg-12 mb-4">
            <h2 class="text-center">Recent Activities</h2>
            <div class="list-group shadow-sm">
                @foreach($recentActivities as $activity)
                    <a href="#" class="list-group-item list-group-item-action">
                        <div class="d-flex justify-content-between">
                            <span>{{ $activity->description }}</span>
                            <small class="text-muted">{{ $activity->created_at->diffForHumans() }}</small>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
body {
    background-color: #f8f9fa;
}

.card {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
    border-radius: 10px;
}

.card:hover {
    transform: scale(1.05);
    box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
}

.btn {
    position: relative;
    overflow: hidden;
    transition: background-color 0.3s ease, transform 0.3s ease;
}

.btn::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(255, 255, 255, 0.2);
    transform: scaleX(0);
    transition: transform 0.3s ease-in-out;
}

.btn:hover {
    transform: translateY(-5px);
}

.btn:hover::before {
    transform: scaleX(1);
}

.alert {
    font-size: 1.2rem;
}

.list-group-item {
    border: none;
    transition: background-color 0.3s ease;
}

.list-group-item:hover {
    background-color: #f1f1f1;
}
</style>
@endsection
@endsection
