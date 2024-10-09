<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display the HR dashboard view.
     */
    public function index()
    {
        return view('hr.dashboard');
    }

    /**
     * Other HR-specific methods can be added here.
     */
}
