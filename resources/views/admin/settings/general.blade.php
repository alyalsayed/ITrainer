@extends('layouts.admin')

@section('content')
<div class="container">
    <h1>General Settings</h1>

    <form action="{{ route('admin.settings.update') }}" method="POST">
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

        @foreach($settings as $setting)
            <div class="form-group">
                <label for="{{ $setting->key }}">{{ ucfirst(str_replace('_', ' ', $setting->key)) }}</label>
                <input type="text" name="{{ $setting->key }}" value="{{ $setting->value }}" class="form-control">
            </div>
        @endforeach

        <button type="submit" class="btn btn-primary">Update Settings</button>
    </form>
</div>
@endsection
