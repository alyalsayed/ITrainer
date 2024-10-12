@extends('layouts.master')

@section('title', 'Create Notes')

@section('content')
<div class="container">
    <h2>Create a Note for {{ $session->name }}</h2>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('notes.store', $session->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group">
            <label for="title">Note Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>
        
        <div class="form-group">
            <label for="type">Note Type</label>
            <select name="type" id="note-type" class="form-control" onchange="renderNoteFields()" required>
                <option value="text">Text</option>
                <option value="code">Code</option>
                <option value="screenshot">Image</option>
            </select>
        </div>

        <!-- Render fields based on the selected type -->
        <div id="note-fields">
            @php
                $noteType = old('type', 'text'); // Default to 'text' if not set
            @endphp

            @if ($noteType === 'text')
                <div class="form-group">
                    <label for="content">Text Content</label>
                    <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                </div>
            @elseif ($noteType === 'code')
                <div class="form-group">
                    <label for="content">Code Content</label>
                    <textarea name="content" class="form-control" rows="5" required>{{ old('content') }}</textarea>
                </div>
            @elseif ($noteType === 'screenshot')
                <div class="form-group">
                    <label for="content">Upload Image</label>
                    <input type="file" name="content" class="form-control-file" accept="image/*" required>
                </div>
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Save Note</button>
    </form>
    
    <script>
        function renderNoteFields() {
            const noteType = document.getElementById('note-type').value;

            // Set a hidden input to preserve the selected note type
            const hiddenInput = document.createElement('input');
            hiddenInput.setAttribute('type', 'hidden');
            hiddenInput.setAttribute('name', 'type');
            hiddenInput.setAttribute('value', noteType);
            document.getElementById('note-fields').appendChild(hiddenInput);

            // Submit the form to re-render fields based on the selected type
            document.querySelector('form').submit();
        }
    </script>
</div>
@endsection
