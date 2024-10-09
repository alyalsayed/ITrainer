<?php

namespace App\Http\Controllers\Admin;

use App\Models\Track;
use App\Models\TrackSession;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class AdminSessionController extends Controller
{
    /**
     * Display a listing of the sessions for a track
     */
    public function index(Track $track)
    {
        $sessions = TrackSession::where('track_id', $track->id)->with(['attendance', 'tasks'])->paginate(10);
        return view('admin.sessions.index', compact('track', 'sessions'));
    }

    /**
     * Show the form for creating a new session
     */
    public function create(Track $track)
    {   $tracks = Track::all();
        return view('admin.sessions.create', compact('tracks','track'));
    }

    /**
     * Store a newly created session in storage
     */
    public function store(Request $request, Track $track)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|in:online,offline',
            'description' => 'nullable|string|max:1000',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $track->sessions()->create($request->only([
            'name',
            'session_date',
            'start_time',
            'end_time',
            'location',
            'description',
        ]));

        return redirect()->route('admin.tracks.sessions.index', $track->id)->with('success', 'Session created successfully.');
    }

    /**
     * Show the form for editing the specified session
     */
    public function edit($trackId,$sessionId)
    {     // Fetch the session to be edited
        $session = TrackSession::findOrFail($sessionId);

        // Fetch the specific track by its ID
        $track = Track::findOrFail($trackId);

        // Fetch all tracks for the dropdown
        $tracks = Track::all();
        return view('admin.sessions.edit', compact('session', 'track','tracks'));
    }

    /**
     * Update the specified session in storage
     */
    public function update(Request $request, Track $track, TrackSession $session)
    {
        // Validate incoming request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'session_date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'location' => 'required|in:online,offline',
            'description' => 'nullable|string|max:1000',
        ]);

        // Check if validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update session data
        $session->name = $request->name;
        $session->session_date = $request->session_date;
        $session->location = $request->location;
        $session->description = $request->description;

        // Ensure start_time and end_time are set in the correct format
        $session->start_time = date('H:i', strtotime($request->start_time));
        $session->end_time = date('H:i', strtotime($request->end_time));

        // Save the updated session
        $session->save();

        // Redirect to sessions index with success message
        return redirect()->route('admin.tracks.sessions.index', $track->id)->with('success', 'Session updated successfully.');
    }

    /**
     * Remove the specified session from storage
     */
    public function destroy(Track $track, TrackSession $session)
    {
        $session->delete();

        return redirect()->route('admin.tracks.sessions.index', $track->id)->with('success', 'Session deleted successfully.');
    }

    /**
     * Display the specified session details
     */
    public function show($trackId, $sessionId)
    {
        $track = Track::findOrFail($trackId);
        $session = TrackSession::with(['attendance', 'tasks', 'notes'])->findOrFail($sessionId);

        return view('admin.sessions.show', compact('track', 'session'));
    }
}
