@extends('layouts.master')

@section('title', 'update ' . ucfirst($user->name))

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <h1 class="mb-4 text-center">Edit User: {{ $user->name }}</h1>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    Edit User Information
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

                    <form action="{{ route('admin.users.update', $user->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label for="userType">User Type</label>
                            <select id="userType" name="userType" class="form-control" required>
                                <option value="">Select User Type</option>
                                @foreach ($userTypes as $type)
                                    <option value="{{ $type }}" {{ old('userType', $user->userType) == $type ? 'selected' : '' }}>
                                        {{ ucfirst($type) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="password">Password <small>(Leave blank to keep current password)</small></label>
                            <input type="password" id="password" name="password" class="form-control">
                        </div>

                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <small>(Leave blank if not changing)</small></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary btn-sm">Save Changes</button>
                        <a href="{{ route('admin.users.index', ['type' => $user->userType]) }}" class="btn btn-secondary btn-sm">Cancel</a>
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
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }
    .card-header {
        background-color: #f1f1f1;
        color: #333;
        text-align: center;
        font-weight: bold;
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
