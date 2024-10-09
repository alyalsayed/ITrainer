<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Track;
use App\Models\Session;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Validator;


class AdminTrackController extends Controller
{
    /**
     * Constructor to apply middleware for authorization
     */


    /**
     * Display a listing of the tracks
     */
    public function index()
    {
        // Fetch all tracks with pagination
        $tracks = Track::paginate(10);

        // Fetch instructors
        $instructors = User::where('userType', 'instructor')->get();

        // Pass both tracks and instructors to the view
        return view('admin.tracks.index', compact('tracks', 'instructors'));
    }


    /**
     * Show the form for creating a new track
     */
    public function create()
    {
        $instructors = User::where('userType', 'instructor')->get();
        $hrManagers = User::where('userType', 'hr')->get();
        $track = new Track();
        return view('admin.tracks.create', compact('instructors', 'hrManagers','track'));
    }

    /**
     * Store a newly created track in storage
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'instructor_id' => 'required|exists:users,id',
            'hr_id' => 'nullable|exists:users,id',
            'sessions' => 'nullable|array',
            'sessions.*.name' => 'required|string|max:255',
            'sessions.*.session_date' => 'required|date',
            'sessions.*.start_time' => 'required|date_format:H:i',
            'sessions.*.end_time' => 'required|date_format:H:i|after:sessions.*.start_time',
            'sessions.*.location' => 'required|in:online,offline',
            'sessions.*.description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        DB::beginTransaction();

        try {
            $track = Track::create($request->only([
                'name',
                'description',
                'start_date',
                'end_date',
                'instructor_id',
                'hr_id',
            ]));

            if ($request->has('sessions')) {
                foreach ($request->sessions as $sessionData) {
                    $track->sessions()->create($sessionData);
                }
            }

            DB::commit();

            return redirect()->route('admin.tracks.index')->with('success', 'Track created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->withErrors(['error' => 'Failed to create track. Please try again.'])->withInput();
        }
    }

    /**
     * Display the specified track details
     */
    public function show(Track $track)
    {
        $track->load(['sessions', 'instructor', 'hr']);
        return view('admin.tracks.show', compact('track'));
    }

    /**
     * Show the form for editing the specified track
     */
    public function edit(Track $track)
    {
        $instructors = User::where('userType', 'instructor')->get();
        $hrManagers = User::where('userType', 'hr')->get();

        return view('admin.tracks.edit', compact('track', 'instructors', 'hrManagers'));
    }

    /**
     * Update the specified track in storage
     */
    public function update(Request $request, Track $track)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:1000',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'instructor_id' => 'required|exists:users,id',
            'hr_id' => 'nullable|exists:users,id',
            'instructor_id' => 'required|exists:users,id',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update the track information
        $track->update($request->only([
            'name',
            'description',
            'start_date',
            'end_date',
            'instructor_id',
            'hr_id',
        ]));

        // Check if sessions exist before processing
        if ($request->has('sessions')) {
            // Update or create sessions
            foreach ($request->sessions as $sessionId => $sessionData) {
                if (isset($sessionId) && $sessionId) {
                    // Update existing session if ID is provided
                    $session = Session::find($sessionId);
                    if ($session) {
                        $session->update(array_filter($sessionData)); // Only update non-empty fields
                    }
                } else {
                    // Create new session if no ID is provided
                    Session::create(array_merge($sessionData, ['track_id' => $track->id]));
                }
            }
        }

        return redirect()->route('admin.tracks.index')->with('success', 'Track updated successfully.');
    }

    /**
     * Remove the specified track from storage
     */
    public function destroy(Track $track)
    {
        $track->delete();

        return redirect()->route('admin.tracks.index')->with('success', 'Track deleted successfully.');
    }
}
