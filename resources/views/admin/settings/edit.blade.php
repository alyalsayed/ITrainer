@extends('layouts.master')

@section('title', 'Edit Setting')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Edit Setting</h1>

    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="card-title">Edit Setting</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.settings.update', $setting->id) }}" method="POST">
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
                    <label for="key" class="form-label">Key</label>
                    <input type="text" name="key" class="form-control" id="key" value="{{ $setting->key }}" readonly>
                </div>
                <div class="form-group mb-3">
                    <label for="value" class="form-label">Value</label>
                    <input type="text" name="value" class="form-control" id="value" value="{{ $setting->value }}" required>
                </div>
                <button type="submit" class="btn btn-success">Update Setting</button>
            </form>
        </div>
    </div>
</div>
@endsection
