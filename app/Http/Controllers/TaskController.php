<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Track;
use App\Models\TrackSession;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Notifications\TaskAddedNotification;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($sessionId)
    {
        // Retrieve all tasks for the session along with their submissions
        $session = TrackSession::findOrFail($sessionId);
        $tasks = $session->tasks()->with(['submissions'])->get();
        return view('tasks.index', compact('tasks', 'session', 'sessionId'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($sessionId)
    {
        // Fetch the session to relate the task to
        $session = TrackSession::findOrFail($sessionId);
        return view('tasks.create', compact('session'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $sessionId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        // Create the task and associate it with the session
        $task = new Task($request->all());
        $task->session_id = $sessionId;
        $task->save();

        // Send notification to all students in the track
        $students = $task->session->track->users()->where('userType', 'student')->get();
    
        foreach ($students as $student) {
            $student->notify(new TaskAddedNotification($task, $sessionId));
        }

        return redirect()->route('sessions.tasks.index', $sessionId)->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($sessionId, $taskId)
    {
        $task = Task::with('submissions')->findOrFail($taskId); // Fetch the task along with its submissions
        $submissions = $task->submissions; // Retrieve the submissions associated with the task
        //   return  $submissions ;
        return view('tasks.show', compact('task', 'submissions'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($sessionId, $taskId)
    {
        $task = Task::findOrFail($taskId);
    
        // Ensure due_date is a Carbon instance
        if (is_string($task->due_date)) {
            $task->due_date = Carbon::parse($task->due_date);
        }
    
        return view('tasks.edit', compact('task'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $sessionId, $taskId)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
        ]);

        $task = Task::findOrFail($taskId);
        $task->update($request->all());

        return redirect()->route('sessions.tasks.index', $sessionId)->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sessionId, $taskId)
    {
        $task = Task::findOrFail($taskId);
        $task->delete();

        return redirect()->route('sessions.tasks.index', $sessionId)->with('success', 'Task deleted successfully.');
    }
    public function submit(Request $request, $sessionId, $taskId)
    {
        // Validate the request inputs
        $request->validate([
            'submission_type' => 'required|in:file,link',
            // Conditional validation based on submission type
            'submission' => $request->submission_type === 'file'
                ? 'required|file|max:2048'
                : 'required|string|url',
        ]);

        // Create the submission instance
        $submission = new TaskSubmission();
        $submission->student_id = Auth::id();
        $submission->task_id = $taskId;

        // Define the path for the session submissions
        $sessionDirectory = storage_path('app/submissions/' . $sessionId);

        // Create the session directory if it doesn't exist
        if (!File::exists($sessionDirectory)) {
            File::makeDirectory($sessionDirectory, 0755, true);
        }

        // Handle file or link submission
        if ($request->submission_type === 'file') {
            $filename = time() . '_' . $request->file('submission')->getClientOriginalName();
            $path = $request->file('submission')->storeAs('submissions/' . $sessionId, $filename);
            $submission->submission = $path;
        } else {
            $submission->submission = $request->submission; // Use the link input
        }

        $submission->submission_type = $request->submission_type;
        $submission->save();

        return redirect()->route('sessions.tasks.show', [$sessionId, $taskId])
            ->with('success', 'Submission successful!');
    }
    public function showGradeForm($sessionId, $taskId, $submissionId)
{
    $submission = TaskSubmission::findOrFail($submissionId);

    return view('tasks.grade', compact('submission'));
}

public function grade(Request $request, $sessionId, $taskId, $submissionId)
{
    $submission = TaskSubmission::findOrFail($submissionId);

    // Validate the grading input
    $request->validate([
        'grade' => 'required|numeric|min:0|max:10',
        'feedback' => 'nullable|string',
    ]);

    // Update the submission with grade and feedback
    $submission->grade = $request->grade;
    $submission->feedback = $request->feedback;
    $submission->save();

    return redirect()->route('sessions.tasks.show', [$sessionId, $taskId])
                     ->with('success', 'Task graded successfully!');
}

}
