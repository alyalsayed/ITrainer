<?php

namespace App\Http\Controllers\Admin;

use App\Models\Task;
use App\Models\User;
use App\Models\Track;
use App\Models\Session;
use App\Models\Attendance;
use Illuminate\Http\Request;
use App\Models\TaskSubmission;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class AdminDashboardController extends Controller
{
    /**
     * Constructor to apply middleware for authorization
     */


    /**
     * Display the admin dashboard view with aggregated data
     */
    public function index()
    {
        // Utilize caching for performance
        $dashboardData = Cache::remember('dashboardData', 60, function () {
            return [
                'studentCount' => User::where('userType', 'student')->count(),
                'instructorCount' => User::where('userType', 'instructor')->count(),
                'hrCount' => User::where('userType', 'hr')->count(),
                'adminCount' => User::where('userType', 'admin')->count(),
                'totalTracks' => Track::count(),
                'totalSessions' => Session::count(),
                'totalAttendances' => Attendance::count(),
                'pendingTasks' => TaskSubmission::whereNull('grade')->count(),
            ];
        });

        return view('admin.dashboard', $dashboardData);
    }

    /**
     * Clear dashboard cache manually if needed
     */
    public function clearCache()
    {
        Cache::forget('dashboardData');
        return redirect()->route('admin.dashboard.index')->with('success', 'Dashboard cache cleared.');
    }
}
