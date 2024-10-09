@extends('layouts.master')

@section('title', 'View ' . ucfirst($user->name))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-center">View User: {{ $user->name }}</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    User Details
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> {{ $user->name }}</p>
                    <p><strong>Email:</strong> {{ $user->email }}</p>
                    <p><strong>Role:</strong> {{ ucfirst($user->userType) }}</p>
                </div>
                <div class="card-footer text-right">
                    <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this user?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                    </form>
                    <a href="{{ route('admin.users.index', ['type' => $user->userType]) }}" class="btn btn-secondary btn-sm">Back to List</a>
                </div>

            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    body {
        background-color: #f8f9fa;
    }
    .card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
        background-color: #ffffff;
        padding: 20px;
    }
    .card-header {
        background-color: #e9ecef;
        color: #343a40;
        text-align: center;
        font-size: 18px;
        font-weight: bold;
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
    }
    .card-body p {
        font-size: 16px;
        color: #495057;
        line-height: 1.6;
    }
    .btn-sm {
        padding: 8px 15px;
        font-size: 14px;
    }
    .btn-warning {
        background-color: #ffc107;
        border-color: #ffc107;
    }
    .btn-danger {
        background-color: #dc3545;
        border-color: #dc3545;
    }
    .btn-secondary {
        background-color: #6c757d;
        border-color: #6c757d;
    }
    h1 {
        font-size: 24px;
        font-weight: 600;
        color: #343a40;
    }
</style>
@endsection
