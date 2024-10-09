<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Session;
use App\Models\Attendance;
use App\Models\Track;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class AdminAttendanceController extends Controller
{
    /**
     * Constructor to apply middleware for authorization
     */

    /**
     * Display the attendance records for a session
     */
    public function index(Track $track, Session $session)
    {


        $attendance = $session->attendance()->with('student')->get();
        return view('admin.attendance.index', compact('track', 'session', 'attendance'));
    }

    /**
     * Show the form for creating a new attendance record
     */
    public function create(Track $track, Session $session)
    {
        $students = User::where('userType', 'student')->get();
        return view('admin.attendance.create', compact('track', 'session', 'students'));
    }

    /**
     * Store a newly created attendance record in storage
     */
    public function store(Request $request, Track $track, Session $session)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'status' => 'required|in:present,absent',
        ]);

        // Prevent duplicate attendance records
        $existing = Attendance::where('student_id', $request->user_id)
            ->where('session_id', $session->id)
            ->first();

        if ($existing) {
            return redirect()->back()->withErrors(['user_id' => 'Attendance already marked for this user.']);
        }

        $session->attendance()->create([
            'student_id' => $request->user_id,
            'status' => $request->status,
        ]);

        return redirect()->route('admin.tracks.sessions.attendance.index', [$track->id, $session->id])->with('success', 'Attendance marked successfully.');
    }

    /**
     * Remove the specified attendance record from storage
     */
    public function destroy(Track $track, Session $session, Attendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('admin.tracks.sessions.attendance.index', [$track->id, $session->id])->with('success', 'Attendance record deleted.');
    }
}
