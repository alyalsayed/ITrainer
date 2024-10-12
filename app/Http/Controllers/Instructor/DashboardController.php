<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrackSession;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;
use App\Models\Track;
use App\Models\Attendance;
use App\Models\SessionNote;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Get all tracks associated with the instructor
        $tracks = Auth::user()->tracks()->pluck('id');
        
        // Get sessions associated with those tracks
        $sessions = TrackSession::whereIn('track_id', $tracks)->get();
        
        // Get tasks associated with those sessions
        $tasks = Task::whereIn('session_id', $sessions->pluck('id'))->get();
        
        // Get the number of students in each track
        $studentCount = DB::table('track_user')
            ->join('users', 'track_user.user_id', '=', 'users.id')
            ->whereIn('track_id', $tracks)
            ->where('users.userType', 'student')
            ->select(DB::raw('track_id, COUNT(track_user.user_id) as student_count'))
            ->groupBy('track_id')
            ->get();
    
        // Get attendance records for sessions
        $attendanceRecords = Attendance::whereIn('session_id', $sessions->pluck('id'))
            ->select('session_id', 
                DB::raw('COUNT(CASE WHEN status = "present" THEN 1 END) as present_count'), 
                DB::raw('COUNT(*) as total_count'))
            ->groupBy('session_id')
            ->get();
        
        // Get total notes count
        $notesCount = SessionNote::count(); 
    
        // Calculate the attendance rate
        $totalAttendance = $attendanceRecords->sum('total_count');
        $presentAttendance = $attendanceRecords->sum('present_count');
        $attendanceRate = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 2) : 0;
    
        // Prepare attendance data for plotting
        $attendanceData = $attendanceRecords->map(function($record) use ($sessions) {
            $session = $sessions->firstWhere('id', $record->session_id);
            $attendanceRate = $record->total_count > 0 ? round(($record->present_count / $record->total_count) * 100, 2) : 0;
            return [
                'session_name' => optional($session)->session_date->format('Y-m-d'),
                'attendance_rate' => $attendanceRate,
            ];
        })->values()->toArray();
    
        // Calculate submission rate for each session considering multiple tasks
        $totalSubmissionRate = 0;
        foreach ($sessions as $session) {
            $totalStudents = $studentCount->where('track_id', $session->track_id)->sum('student_count');
            $tasksForSession = $tasks->where('session_id', $session->id);

            // Total possible submissions = total tasks * total students
            $totalPossibleSubmissions = $tasksForSession->count() * $totalStudents;
            
            // Count how many submissions were made for all tasks in this session
            $submittedCount = DB::table('task_submissions')
                ->join('tasks', 'task_submissions.task_id', '=', 'tasks.id')
                ->where('tasks.session_id', $session->id)
                ->count('task_submissions.id'); // Count all submissions
            
            // Calculate submission rate based on total possible submissions
            $submissionRate = $totalPossibleSubmissions > 0 ? round(($submittedCount / $totalPossibleSubmissions) * 100, 2) : 0;
    
            $totalSubmissionRate += $submissionRate;
        }

        // Calculate average submission rate across all sessions
        $averageSubmissionRate = count($sessions) > 0 ? round($totalSubmissionRate / count($sessions), 2) : 0;

        return view('instructor.dashboard', compact(
            'sessions', 'tasks', 'studentCount', 'attendanceRecords', 'notesCount', 
            'attendanceRate', 'attendanceData', 'averageSubmissionRate' // Pass average submission rate to the view
        ));
    }
}
