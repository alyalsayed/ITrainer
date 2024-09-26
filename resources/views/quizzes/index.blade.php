@extends('layouts.master')

@section('title', 'Quizzes List')

@section('content')
<div class="container mt-4">
    <h1>Quizzes List</h1>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- Only show the "Create Quiz" button if the user is an instructor --}}
    @if(Auth::user()->userType == 'instructor')
        <a href="{{ route('quizzes.create') }}" class="btn btn-primary mb-3">Add New Quiz</a>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Quiz Name</th>
                <th>Description</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quizzes as $quiz)
                <tr>
                    <td>{{ $quiz->name }}</td>
                    <td>{{ $quiz->description }}</td>
                    <td>{{ $quiz->start_date }}</td>
                    <td>{{ $quiz->end_date }}</td>
                    <td>
                        {{-- View Quiz details --}}
                        <a href="{{ route('quizzes.show', $quiz->id) }}" class="btn btn-info btn-sm">View</a>

                        {{-- Only instructors can edit or delete quizzes --}}
                        @if(Auth::user()->userType == 'instructor')
                            <a href="{{ route('quizzes.edit', $quiz->id) }}" class="btn btn-warning btn-sm">Edit</a>
                            <form action="{{ route('quizzes.destroy', $quiz->id) }}" method="POST" style="display:inline-block;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
