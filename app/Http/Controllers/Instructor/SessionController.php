<?php

namespace App\Http\Controllers\Instructor;

use App\Http\Controllers\Controller;
use App\Http\Requests\Instructor\SessionRequest;
use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\Session;


class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $all_sessions = Session::all();
        return view('instructor.sessions.index', compact('all_sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tracks = Track::all();
        return view('instructor.sessions.create', compact('tracks'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SessionRequest $request)
    {
        Session::create([
            'name' => $request->name,
            'track_id' => $request->track_id,
            'session_date' => $request->session_date,
            'description' => $request->description,
            'location' => $request->location,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('sessions.index')->with('success', 'Session created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $session_data = Session::with('track')->findOrFail($id);
        return view('instructor.sessions.show', compact('session_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $session = Session::findOrFail($id);
        $tracks = Track::all();
        return view('instructor.sessions.edit', compact('session', 'tracks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SessionRequest $request, string $id)
    {
        $session = Session::findOrFail($id);
        $session->update([
            'name' => $request->name,
            'track_id' => $request->track_id,
            'session_date' => $request->session_date,
            'description' => $request->description,
            'location' => $request->location,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);

        return redirect()->route('sessions.index')->with('success', 'Session updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $session = Session::findOrFail($id);
        $session->delete();

        return redirect()->route('sessions.index')->with('success', 'Session deleted successfully');
    }
}
