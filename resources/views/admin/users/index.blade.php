@extends('layouts.master')

@section('title', 'Manage Users')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-center">Manage Users</h1>
        </div>
    </div>

    {{-- Plus Card to Add New User --}}
    <div class="row text-center">
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.users.create') }}" class="card-link">
                <div class="card mb-4 p-3 shadow-sm hover-effect animated-card" style="background-color: #28a745; color: white;">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold">Add New User</h4>
                        <p class="card-text display-4">+</p>
                    </div>
                </div>
            </a>
        </div>
    </div>

    {{-- Entity Type Cards --}}
    <div class="row text-center">
        {{-- Students --}}
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.users.table', ['type' => 'student']) }}" class="card-link">
                <div class="card mb-4 p-3 shadow-sm hover-effect animated-card" style="background-color: #007bff; color: white;">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold">Students</h4>
                        <p class="card-text display-4">{{ $studentCount }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Instructors --}}
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.users.table', ['type' => 'instructor']) }}" class="card-link">
                <div class="card mb-4 p-3 shadow-sm hover-effect animated-card" style="background-color: #28a745; color: white;">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold">Instructors</h4>
                        <p class="card-text display-4">{{ $instructorCount }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- HR --}}
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.users.table', ['type' => 'hr']) }}" class="card-link">
                <div class="card mb-4 p-3 shadow-sm hover-effect animated-card" style="background-color: #ffc107; color: black;">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold">HR</h4>
                        <p class="card-text display-4">{{ $hrCount }}</p>
                    </div>
                </div>
            </a>
        </div>

        {{-- Admins --}}
        <div class="col-sm-6 col-md-3">
            <a href="{{ route('admin.users.table', ['type' => 'admin']) }}" class="card-link">
                <div class="card mb-4 p-3 shadow-sm hover-effect animated-card" style="background-color: #dc3545; color: white;">
                    <div class="card-body">
                        <h4 class="card-title font-weight-bold">Admins</h4>
                        <p class="card-text display-4">{{ $adminCount }}</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>
@endsection
