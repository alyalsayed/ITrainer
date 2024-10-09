@extends('layouts.master')

@section('title', 'Create New User')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-center">Create New User</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    User Information
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('admin.users.store') }}" method="POST">
                        @csrf

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="userType">User Type</label>
                            <select id="userType" name="userType" class="form-control" required>
                                <option value="">Select User Type</option>
                                @foreach ($userTypes as $type)
                                    <option value="{{ $type }}" {{ old('userType') == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Create User</button>
                        <a href="{{ route('admin.users.index', ['type' => 'admin']) }}" class="btn btn-secondary btn-sm">Cancel</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-radius: 10px;
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
    .form-group label {
        font-weight: bold;
    }
    .btn-sm {
        padding: 8px 15px;
        font-size: 14px;
    }
</style>
@endsection
