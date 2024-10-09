<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Activity;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB; // Make sure this line is present

class AdminHomeController extends Controller
{
    /**
     * Constructor to apply middleware for authorization
     */

    /**
     * Handle the incoming request and display analytics
     */
    public function __invoke(Request $request)
    {
        // Fetch recent activities
        $recentActivities = Activity::orderBy('created_at', 'desc')->take(5)->get();

        // Count users grouped by user type
        $userCounts = User::select('userType', DB::raw('count(*) as total')) // Ensure DB is correctly referenced here
            ->groupBy('userType')
            ->pluck('total', 'userType')
            ->toArray();

        // Ensure all user types are present
        $types = ['student', 'instructor', 'hr', 'admin'];
        foreach ($types as $type) {
            if (!isset($userCounts[$type])) {
                $userCounts[$type] = 0;
            }
        }

        // Pass all relevant data to the view
        return view('admin.home', [
            'studentCount' => $userCounts['student'],
            'instructorCount' => $userCounts['instructor'],
            'hrCount' => $userCounts['hr'],
            'adminCount' => $userCounts['admin'],
            'recentActivities' => $recentActivities, // Pass recent activities to the view
        ]);
    }
}
