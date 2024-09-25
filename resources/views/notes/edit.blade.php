@extends('layouts.master')

@section('title', 'Edit Note')

@section('content')
<div class="container">
    <h2>Edit Note</h2>

    <form action="{{ route('notes.update', $note->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="type">Note Type</label>
            <select name="type" id="note-type" class="form-control" onchange="toggleFields()">
                <option value="text">Text</option>
                <option value="code">Code</option>
                <option value="screenshot">Image</option>
            </select>
        </div>
    
        <div id="text-editor" class="form-group">
            <label for="content">Text Content</label>
            <textarea name="content" class="form-control rich-text-editor"></textarea>
        </div>
    
        <div id="code-editor" class="form-group" style="display: none;">
            <label for="content">Code Content</label>
            <textarea name="content" class="form-control code-textarea"></textarea>
        </div>
    
        <div id="image-upload" class="form-group" style="display: none;">
            <label for="content">Upload Image</label>
            <input type="file" name="content" class="form-control-file">
        </div>
    
        <button type="submit" class="btn btn-primary">Update Note</button>
    </form>
</div>
<script>
    function toggleFields() {
        var noteType = document.getElementById('note-type').value;
        document.getElementById('text-editor').style.display = noteType === 'text' ? 'block' : 'none';
        document.getElementById('code-editor').style.display = noteType === 'code' ? 'block' : 'none';
        document.getElementById('image-upload').style.display = noteType === 'screenshot' ? 'block' : 'none';
    }
</script>
{{-- <script>
    CKEDITOR.replace('editor', {
        extraPlugins: 'codesnippet',
        codeSnippet_theme: 'monokai_sublime',
        height: 300,
    });
</script> --}}
@endsection