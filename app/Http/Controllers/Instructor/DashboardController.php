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
use App\Models\User;
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
    
        // Get the number of students in each track (excluding the instructor)
        $studentCount = DB::table('track_user')
            ->join('users', 'track_user.user_id', '=', 'users.id')
            ->whereIn('track_id', $tracks)
            ->where('users.userType', 'student') // Only include students
            ->select(DB::raw('track_id, COUNT(track_user.user_id) as student_count'))
            ->groupBy('track_id')
            ->get();
    
        // Get attendance records for students only, excluding the instructor
        $attendanceRecords = Attendance::whereIn('session_id', $sessions->pluck('id'))
            ->whereIn('student_id', function ($query) {
                // Only include students in the attendance records
                $query->select('id')
                    ->from('users')
                    ->where('userType', 'student');
            })
            ->select('session_id', 'student_id', 'status')
            ->get();
    
        // Get total notes count related to the instructor's sessions
        $notesCount = SessionNote::whereIn('session_id', $sessions->pluck('id'))->count();
    
        // Calculate the total attendance rate for students (excluding the instructor)
        $totalAttendance = $attendanceRecords->count();
        $presentAttendance = $attendanceRecords->where('status', 'present')->count();
        $attendanceRate = $totalAttendance > 0 ? round(($presentAttendance / $totalAttendance) * 100, 2) : 0;
    
        // Prepare attendance data for plotting
        $attendanceData = $sessions->map(function ($session) use ($attendanceRecords) {
            $attendanceForSession = $attendanceRecords->where('session_id', $session->id);
            $totalStudents = DB::table('track_user')
                ->where('track_id', $session->track_id)
                ->whereIn('user_id', function ($query) {
                    $query->select('id')
                        ->from('users')
                        ->where('userType', 'student'); // Ensure only students are counted
                })
                ->count();
    
            $presentCount = $attendanceForSession->where('status', 'present')->count();
            $attendanceRate = $totalStudents > 0 ? round(($presentCount / $totalStudents) * 100, 2) : 0;
    
            return [
                'session_name' => optional($session)->session_date->format('Y-m-d'),
                'attendance_rate' => $attendanceRate,
            ];
        })->values()->toArray();
    
        // Get only students associated with the instructor's tracks
        $students = User::where('userType', 'student')
            ->whereIn('id', function ($query) use ($tracks) {
                $query->select('user_id')
                    ->from('track_user')
                    ->whereIn('track_id', $tracks);
            })
            ->with(['attendances', 'taskSubmissions'])
            ->get();
    
        // Correctly calculate attendance rate and submission rate for each student
        $studentDetails = $students->map(function ($student) use ($sessions) {
            // Total number of sessions the student should attend
            $totalSessions = $sessions->count();
    
            // Number of sessions where the student was present
            $presentCount = $student->attendances->whereIn('session_id', $sessions->pluck('id'))->where('status', 'present')->count();
    
            // Calculate attendance rate for the student
            $attendanceRate = $totalSessions > 0 ? round(($presentCount / $totalSessions) * 100, 2) : 0;
    
            // Calculate submission rate for the student
            $totalTasks = Task::whereIn('session_id', $sessions->pluck('id'))->count();
            $submissionCount = $student->taskSubmissions->count();
            $submissionRate = $totalTasks > 0 ? round(($submissionCount / $totalTasks) * 100, 2) : 0;
    
            return [
                'name' => $student->name,
                'email' => $student->email,
                'attendance_rate' => $attendanceRate,
                'submission_rate' => $submissionRate,
            ];
        });
    
        // Calculate the average attendance rate across all students
        $averageAttendanceRate = $studentDetails->avg('attendance_rate');
        $averageSubmissionRate = $studentDetails->avg('submission_rate');
    
        return view('instructor.dashboard', compact(
            'sessions',
            'tasks',
            'studentCount',
            'attendanceRecords',
            'notesCount',
            'attendanceRate',
            'attendanceData',
            'averageAttendanceRate', 
            'averageSubmissionRate', 
            'studentDetails'
        ));
    }
    
}
