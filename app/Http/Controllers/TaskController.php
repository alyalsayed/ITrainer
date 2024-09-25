<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\TaskSubmission;
use App\Models\Track;
use App\Models\TrackSession;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tasks = Task::with('submissions')->get();
      //  return $tasks;
        return view('tasks.index', compact('tasks'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $sessions=TrackSession::all();
        return view('tasks.create',compact('sessions'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'session_id' => 'required|exists:track_sessions,id',
            
        ]);

        Task::create($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $task = Task::with('submissions.user')->findOrFail($id);
  
        $submissions = $task->submissions->map(function ($submission) {
            $submission->status = $submission->getStatusAttribute();
            return $submission;
        });
        
        return view('tasks.show', compact('task', 'submissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $task = Task::findOrFail($id);
        return view('tasks.edit', compact('task'));
    }
      
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'due_date' => 'required|date',
            'session_id' => 'required|exists:track_sessions,id',
        ]);

        $task = Task::findOrFail($id);
        $task->update($request->all());
        return redirect()->route('tasks.index')->with('success', 'Task updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $task = Task::findOrFail($id);
        $task->delete();
        return redirect()->route('tasks.index')->with('success', 'Task deleted successfully.');
    }
    public function submit(Request $request, Task $task)
    {
        $request->validate([
            'submission_type' => 'required|in:file,link',
            'submission' => $request->submission_type === 'file' ? 'required|file' : 'required|string',
        ]);
    
        $submissionData = [
            'student_id' => Auth::user()->id,
            'task_id' => $task->id,
            'submission_type' => $request->submission_type,
            'submission' => $request->submission_type === 'file' ? $request->file('submission')->store('submissions') : $request->submission,
        ];
    
        TaskSubmission::create($submissionData);
    
        return redirect()->route('tasks.show', $task->id)->with('success', 'Task submitted successfully.');
    }
    
}
