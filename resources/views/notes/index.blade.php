@extends('layouts.master')

@section('title', 'Notes')

@section('content')
<div class="container">
    <h1 class="mb-4">Notes for Session: {{ $session->name }}</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="row">
        @foreach ($notes as $note)
            <div class="col-md-12 mb-4">
                <div class="card">
                    <div class="card-body position-relative">
                        <!-- Display Title -->
                        <h2 class="card-title text-center" id="note-title-{{ $note->id }}">{{ $note->title }}</h2>
                        
                        <!-- Editable Form -->
                        <div class="note-display" id="note-display-{{ $note->id }}" style="display: block;">
                            @if ($note->type === 'text')
                                <div style="text-align: justify; text-indent: 1em;">
                                    {!! nl2br(e($note->content)) !!}
                                </div>
                            @elseif ($note->type === 'code')
                                <pre><code>{!! nl2br(e($note->content)) !!}</code></pre>
                            @elseif ($note->type === 'screenshot')
                                <img src="{{ asset('storage/' . $note->content) }}" alt="Image Note" class="img-fluid mx-auto d-block my-3" width="70%" height="auto">
                            @endif
                        </div>

                        <!-- Edit Form -->
                        <form id="edit-form-{{ $note->id }}" action="{{ route('notes.update', $note->id) }}" method="POST" enctype="multipart/form-data" style="display: none;">
                            @csrf
                            @method('PUT')

                            <!-- Title Edit -->
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" name="title" class="form-control" value="{{ $note->title }}" required>
                            </div>

                            <!-- Type Edit -->
                            <div class="form-group">
                                <label for="type">Type</label>
                                <select name="type" class="form-control" onchange="updateContentField({{ $note->id }})" required>
                                    <option value="text" {{ $note->type === 'text' ? 'selected' : '' }}>Text</option>
                                    <option value="code" {{ $note->type === 'code' ? 'selected' : '' }}>Code</option>
                                    <option value="screenshot" {{ $note->type === 'screenshot' ? 'selected' : '' }}>Image</option>
                                </select>
                            </div>

                            <!-- Content Edit -->
                            <div class="form-group">
                                <label for="content">Content</label>
                                @if ($note->type === 'screenshot')
                                    <input type="file" name="content" class="form-control" accept="image/*">
                                    <small class="form-text text-muted">Leave blank to keep the current image.</small>
                                @else
                                    <textarea name="content" class="form-control" rows="10" required>{{ $note->content }}</textarea>
                                @endif
                            </div>

                            <button type="submit" class="btn btn-success">Save</button>
                            <button type="button" class="btn btn-secondary" onclick="toggleEdit({{ $note->id }}, false)">Cancel</button>
                        </form>

                        <!-- Edit and Delete Icons -->
                        <div class="note-buttons position-absolute" style="top: 20px; right: 20px;">
                            <button class="btn btn-sm btn-warning" onclick="toggleEdit({{ $note->id }}, true)" title="Edit">
                                <i class="fa fa-edit"></i>
                            </button>

                            <form action="{{ route('notes.destroy', $note->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this note?')" title="Delete">
                                    <i class="fa fa-trash"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Button to add a new note at the end -->
    <button id="add-note-btn" class="btn btn-primary my-3" style="width: 100px; height: 50px; font-size: 24px;">+</button>

    <!-- New Note Form -->
    <form id="create-note-form" action="{{ route('notes.store', $session->id) }}" method="POST" enctype="multipart/form-data" style="display: none;" class="p-4 bg-light">
        @csrf
        <h2 class="mb-4">Add a New Note</h2>
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="type">Type</label>
            <select name="type" class="form-control" required>
                <option value="text">Text</option>
                <option value="code">Code</option>
                <option value="screenshot">Image</option>
            </select>
        </div>

        <div class="form-group">
            <label for="content">Content</label>
            <textarea name="content" class="form-control" rows="10" required></textarea>
        </div>

        <div class="form-group" id="screenshot-upload" style="display: none;">
            <label for="content">Upload Image</label>
            <input type="file" name="content" class="form-control" accept="image/*">
        </div>

        <button type="submit" class="btn btn-success">Add Note</button>
        <button type="button" class="btn btn-secondary" id="cancel-create-btn" onclick="toggleCreateForm(false)">Cancel</button>
    </form>
</div>

<script>
    // Function to toggle the create note form
    document.getElementById('add-note-btn').addEventListener('click', function() {
        const form = document.getElementById('create-note-form');
        const button = document.getElementById('add-note-btn');
        
        // Hide the button and show the form
        button.style.display = 'none'; // Hide button
        form.style.display = 'block';   // Show form

        // Reset the form fields
        form.reset();
    });

    // Function to cancel creating a note
    function toggleCreateForm(isVisible = true) {
        const form = document.getElementById('create-note-form');
        const button = document.getElementById('add-note-btn');

        form.style.display = isVisible ? (form.style.display === 'none' ? 'block' : 'none') : 'none'; // Toggle form display
        button.style.display = isVisible ? 'none' : 'block'; // Show button if form is hidden
    }

    // Function to toggle the edit form
    function toggleEdit(noteId, isEditMode) {
        const displayDiv = document.getElementById(`note-display-${noteId}`);
        const form = document.getElementById(`edit-form-${noteId}`);
        const buttons = document.getElementById(`note-buttons-${noteId}`);
        
        if (isEditMode) {
            displayDiv.style.display = 'none';  // Hide note content
            form.style.display = 'block';       // Show edit form
            buttons.style.display = 'none';     // Hide edit/delete buttons
        } else {
            displayDiv.style.display = 'block';  // Show note content
            form.style.display = 'none';         // Hide edit form
            buttons.style.display = 'block';     // Show edit/delete buttons
        }
    }

    // Handle content field display for create form
    document.querySelector('select[name="type"]').addEventListener('change', function() {
        const type = this.value;
        const screenshotUpload = document.getElementById('screenshot-upload');
        if (type === 'screenshot') {
            screenshotUpload.style.display = 'block';
            document.querySelector('textarea[name="content"]').style.display = 'none';
        } else {
            screenshotUpload.style.display = 'none';
            document.querySelector('textarea[name="content"]').style.display = 'block';
        }
    });
</script>
@endsection
