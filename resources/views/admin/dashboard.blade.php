@extends('layouts.master')

@section('title', 'Admin Dashboard')

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">Admin Dashboard</h1>

    <div class="row justify-content-center">
        <!-- Card for User Analytics -->
        <div class="col-md-3">
            <div class="card text-dark bg-light mb-4 shadow-sm card-hover" style="background-color: #e7f1ff;">
                <div class="card-body text-center">
                    <h5 class="card-title">User Analytics</h5>
                    <p class="card-text">Track the activity of your users over time.</p>
                    <a href="#" class="btn btn-primary btn-block">View Analytics</a>
                </div>
            </div>
        </div>

        <!-- Card for User Management -->
        <div class="col-md-3">
            <div class="card text-dark bg-light mb-4 shadow-sm card-hover" style="background-color: #d4edda;">
                <div class="card-body text-center">
                    <h5 class="card-title">Manage Users</h5>
                    <p class="card-text">Add, edit, or remove users easily.</p>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-success btn-block">Go to Users</a>
                </div>
            </div>
        </div>

        <!-- Card for Settings -->
        <div class="col-md-3">
            <div class="card text-dark bg-light mb-4 shadow-sm card-hover" style="background-color: #fff3cd;">
                <div class="card-body text-center">
                    <h5 class="card-title">Settings</h5>
                    <p class="card-text">Update admin preferences and system configurations.</p>
                    <a href="{{ route('admin.settings.index') }}" class="btn btn-warning btn-block">Go to Settings</a>
                </div>
            </div>
        </div>

        <!-- Card for Tracks -->
        <div class="col-md-3">
            <div class="card text-dark bg-light mb-4 shadow-sm card-hover" style="background-color: #f8d7da;">
                <div class="card-body text-center">
                    <h5 class="card-title">Tracks</h5>
                    <p class="card-text">Manage tracks and their sessions.</p>
                    <a href="{{ route('admin.tracks.index') }}" class="btn btn-danger btn-block">View Tracks</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card-hover {
        transition: transform 0.3s, box-shadow 0.3s;
    }

    .card-hover:hover {
        transform: scale(1.05); /* Slightly increase the size */
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2); /* Add shadow on hover */
    }

    .card-title {
        font-size: 1.25rem; /* Slightly larger font size for better visibility */
        font-weight: 600;
        margin-bottom: 1rem;
    }

    .card-body p {
        font-size: 0.95rem;
    }

    .btn-block {
        width: 100%; /* Make buttons full width */
    }

    .container h1 {
        font-size: 2.5rem;
        margin-bottom: 2.5rem; /* Increased bottom margin for better spacing */
    }

    .row {
        margin-top: 20px; /* Increase space between the row of cards and heading */
    }
</style>
@endsection

