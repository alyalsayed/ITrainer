<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\{Attendance, SessionNote, Task, TrackSession};

class DashboardController extends Controller
{
    public function index()
    {
        // Get the authenticated student
        $student = Auth::user();

        // Get the sessions associated with the student's tracks
        $tracks = $student->tracks()->pluck('id');
        $sessions = TrackSession::whereIn('track_id', $tracks)->get();

        // Get tasks associated with those sessions
        $tasks = Task::whereIn('session_id', $sessions->pluck('id'))->get();

        // Get attendance records for the student
        $attendanceRecords = Attendance::where('student_id', $student->id)
            ->whereIn('session_id', $sessions->pluck('id'))
            ->get();

        // Get total notes count related to the student's sessions
        $notesCount = SessionNote::whereIn('session_id', $sessions->pluck('id'))->count();

        // Calculate attendance rate for the student
        $totalSessions = $sessions->count();
        $presentCount = $attendanceRecords->where('status', 'present')->count();
        $attendanceRate = $totalSessions > 0 ? round(($presentCount / $totalSessions) * 100, 2) : 0;

        // Calculate submission rate for the student
        $submissionCount = $student->taskSubmissions->whereIn('task_id', $tasks->pluck('id'))->count();
        $totalTasks = $tasks->count();
        $submissionRate = $totalTasks > 0 ? round(($submissionCount / $totalTasks) * 100, 2) : 0;

        // Pass all the required variables to the view
        return view('student.dashboard', compact(
            'sessions',
            'tasks',
            'attendanceRecords',
            'notesCount',
            'attendanceRate',
            'submissionRate',
            'submissionCount' 
        ));
    }
}
