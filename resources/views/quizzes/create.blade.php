@extends('layouts.master')

@section('title', 'Create quiz')

@section('content')
    <div class="container mt-4">
        <h1>Create quiz</h1>

        {{-- General error message for invalid form submission --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                Please correct the errors below and try again.
            </div>
        @endif

        <form action="{{ route('quizzes.store') }}" method="POST">
            @csrf

            {{-- Quiz Name --}}
            <div class="form-group my-3">
                <label for="name">Quiz Name</label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" required>
                @if ($errors->has('name'))
                    <div class="text-danger">
                        {{ $errors->first('name') }}
                    </div>
                @endif
            </div>

            {{-- Quiz Description --}}
            <div class="form-group my-3">
                <label for="description">Description</label>
                <textarea id="description" name="description" class="form-control" rows="4">{{ old('description') }}</textarea>
                @if ($errors->has('description'))
                    <div class="text-danger">
                        {{ $errors->first('description') }}
                    </div>
                @endif
            </div>

            {{-- Start Date --}}
            <div class="form-group my-3">
                <label for="start_date">Start Time</label>
                <input type="datetime-local" id="start_date" name="start_time" class="form-control"
                    value="{{ old('start_date') }}" required>
                @if ($errors->has('start_date'))
                    <div class="text-danger">
                        {{ $errors->first('start_date') }}
                    </div>
                @endif
            </div>

            {{-- End Date --}}
            <div class="form-group my-3">
                <label for="end_date">end Time</label>
                <input type="datetime-local" id="end_date" name="end_time" class="form-control"
                    value="{{ old('end_date') }}" required>
                @if ($errors->has('end_date'))
                    <div class="text-danger">
                        {{ $errors->first('end_date') }}
                    </div>
                @endif
            </div>


            {{-- Type --}}
            <div class="form-group my-3">
                <label for="quiz_type">Type</label>
                <select name="quiz_type" id="quiz_type" class="form-control" required>
                    <option value="0">Don't Show Degree Upon Sumbission</option>
                    <option value="1">Show Degree Wihtout Correction</option>
                    <option value="2">Show Degree and Correction</option>
                </select>
                @if ($errors->has('quiz_type'))
                    <div class="text-danger">
                        {{ $errors->first('quiz_type') }}
                    </div>
                @endif
            </div>
            <div id="questions-container">
                <div class="form-group border p-3 rounded position-relative" id="questionForm">
                    <!-- Question Title -->
                    <label for="questionTitle">Question Title</label>
                    <input type="text" class="form-control" id="questionTitle" placeholder="Enter the question title"
                        required>
    
                    <!-- Required Switch -->
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" id="requiredSwitch" checked>
                        <label class="form-check-label" for="requiredSwitch">Required</label>
                    </div>
    
                    <!-- Answers -->
                    <label for="answers">Answers</label>
    
                    <div id="answers-container">
                        <div class="input-group mb-2 answer-field">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="correctAnswer" aria-label="Correct answer">
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter answer 1" required>
                        </div>
    
                        <div class="input-group mb-2 answer-field">
                            <div class="input-group-prepend">
                                <div class="input-group-text">
                                    <input type="radio" name="correctAnswer" aria-label="Correct answer">
                                </div>
                            </div>
                            <input type="text" class="form-control" placeholder="Enter answer 2" required>
                        </div>
                    </div>
    
                    <!-- Add and Remove Answer Buttons -->
                    <div class="mt-2">
                        <button type="button" class="btn btn-outline-primary" id="addAnswerBtn">+</button>
                        <button type="button" class="btn btn-outline-danger" id="removeAnswerBtn">-</button>
                    </div>
    
                    <!-- Advanced Options and Delete Question Buttons -->
                    <div class="position-absolute" style="top: 0; right: 0;">
                        <button type="button" class="btn btn-sm btn-link" id="toggleAdvancedBtn">Advanced Options</button>
                        <button type="button" class="btn btn-sm btn-link text-danger" id="deleteQuestionBtn">Delete</button>
                    </div>
    
                    <!-- Advanced Options (Initially Hidden) -->
                    <div id="advancedOptions" class="mt-3" style="display: none;">
                        <div class="form-group">
                            <label for="questionType">Question Type</label>
                            <select class="form-control" id="questionType">
                                <option value="single">One correct answer</option>
                                <option value="multiple">Multiple correct answers</option>
                            </select>
                        </div>
    
                        <div class="form-group">
                            <label for="grade">Grade (Default 1)</label>
                            <input type="number" class="form-control" id="grade" step="1" value="1"
                                placeholder="Enter grade" required>
                        </div>
                    </div>
                </div>
            </div>


            



            {{-- Submit Button --}}
            <button type="submit" class="btn btn-primary mt-3">Create quiz</button>
        </form>
    </div>


@endsection
@section('scripts')
    <script>
        let answerCount = 2;

        // Add more answer fields
        document.getElementById('addAnswerBtn').addEventListener('click', function() {
            answerCount++;
            const answerContainer = document.createElement('div');
            answerContainer.classList.add('input-group', 'mb-2', 'answer-field');
            answerContainer.innerHTML = `
        <div class="input-group-prepend">
          <div class="input-group-text">
            <input type="radio" name="correctAnswer" aria-label="Correct answer">
          </div>
        </div>
        <input type="text" class="form-control" placeholder="Enter answer ${answerCount}" required>
      `;
            document.getElementById('answers-container').appendChild(answerContainer);
        });

        // Remove the last answer field
        document.getElementById('removeAnswerBtn').addEventListener('click', function() {
            const answerFields = document.querySelectorAll('.answer-field');
            if (answerFields.length > 2) { // Ensure at least 2 answers remain
                answerFields[answerFields.length - 1].remove();
                answerCount--;
            }
        });

        // Toggle advanced options visibility
        document.getElementById('toggleAdvancedBtn').addEventListener('click', function() {
            const advancedOptions = document.getElementById('advancedOptions');
            advancedOptions.style.display = advancedOptions.style.display === 'none' ? 'block' : 'none';
        });

        // Delete the entire question form
        document.getElementById('deleteQuestionBtn').addEventListener('click', function() {
            const questionForm = document.getElementById('questionForm');
            questionForm.remove(); // Remove the entire form group
        });

        // Handle change of question type (single or multiple answers)
        document.getElementById('questionType').addEventListener('change', function() {
            const answerFields = document.querySelectorAll(
                '.answer-field input[type="radio"], .answer-field input[type="checkbox"]');
            const questionType = this.value;

            answerFields.forEach(function(field) {
                if (questionType === 'multiple') {
                    field.type = 'checkbox'; // Change to checkbox for multiple correct answers
                } else {
                    field.type = 'radio'; // Change back to radio for single correct answer
                }
            });
        });
    </script>
@endsection
