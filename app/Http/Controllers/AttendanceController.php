<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\TrackSession;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AttendanceController extends Controller
{
    public function showAttendanceForm($sessionId)
    {
        // Get the session details
        $session = TrackSession::findOrFail($sessionId);
        $track = $session->track;
    
        // Fetch students registered for this track
        $students = $track->users()->where('userType', 'student')->get();
    
        $attendanceRecords = Attendance::where('session_id', $sessionId)->get()->keyBy('student_id');
    
        $attendanceRecord = null;
        if (Auth::user()->userType === 'student') {
            $attendanceRecord = $attendanceRecords[Auth::id()] ?? null; 
        }
        
    
        return view('attendance.index', compact('session', 'students', 'attendanceRecords', 'attendanceRecord'));
    }
    

    public function storeAttendance(Request $request, $sessionId)
    {
    // Get all the student IDs that were marked as present
    $presentStudents = $request->input('attendance', []);

    // Get the session details
    $session = TrackSession::findOrFail($sessionId);
    $track = $session->track;

    // Fetch students registered for this track
    $students = $track->users()->where('userType', 'student')->get();

    foreach ($students as $student) {
        // Check if the student was marked as present or absent
        $status = in_array($student->id, $presentStudents) ? 'present' : 'absent';

        // Check if the attendance record already exists
        $attendance = Attendance::where('student_id', $student->id)
                                ->where('session_id', $sessionId)
                                ->first();

        if ($attendance) {
            // Use query builder to update the record directly
            DB::table('attendance')
                ->where('student_id', $student->id)
                ->where('session_id', $sessionId)
                ->update(['status' => $status, 'updated_at' => now()]);
        } else {
            // Use Eloquent to create a new record
            Attendance::create([
                'student_id' => $student->id,
                'session_id' => $sessionId,
                'status' => $status
            ]);
        }
    }

    return redirect()->back()->with('success', 'Attendance updated successfully!');
}
}

