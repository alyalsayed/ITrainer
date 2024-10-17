<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Track;

class DashboardController extends Controller
{
    public function index()
    {
        $totalAdmins = User::where('userType', 'admin')->count();
        $totalInstructors = User::where('userType', 'instructor')->count();
        $totalTracks = Track::count();
        $totalStudents = User::where('userType', 'student')->count();
        $totalHR = User::where('userType', 'hr')->count();
    
        // Data for bar chart
        $tracks = Track::withCount('users')->get();
        $trackNames = $tracks->pluck('name');
        $studentCounts = $tracks->pluck('users_count');

       // return  $studentCounts ;
    
        return view('admin.dashboard', compact('totalAdmins', 'totalInstructors', 'totalTracks', 'totalStudents', 'totalHR', 'trackNames', 'studentCounts'));
    }
    
}
