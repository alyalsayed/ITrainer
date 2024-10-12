<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrackSession;
use App\Models\Track;
use App\Http\Requests\SessionRequest;
use App\Notifications\NewSessionCreated;
use Illuminate\Support\Facades\Auth;


class SessionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $all_sessions =TrackSession::whereIn('track_id', $user->tracks->pluck('id'))->get();
       return view('sessions.index', compact('all_sessions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('sessions.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(SessionRequest $request)
    {
        $request->validated();
        $user = Auth::user();
        $trackId = $user->tracks->first()->id;
        $session=TrackSession::create([
            'name' => $request->name,
            'track_id' => $trackId,
            'session_date' => $request->session_date,
            'description' => $request->description,
            'location' => $request->location,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
        ]);
        $students = $session->track->users()->where('userType', 'student')->get();
    
        foreach ($students as $student) {
            $student->notify(new NewSessionCreated($session));
        }

        return redirect()->route('sessions.index')->with('success', 'Session created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $session_data = TrackSession::with('track')->findOrFail($id);
        return view('sessions.show', compact('session_data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $session = TrackSession::findOrFail($id);
        // $tracks = Track::all();
        return view('sessions.edit', compact('session'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(SessionRequest $request, string $id)
    {
        $session = TrackSession::findOrFail($id);
        $session->update([
            'name' => $request->name,
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
        $session = TrackSession::findOrFail($id);
        $session->notes()->delete();
        
        $session->delete();

        return redirect()->route('sessions.index')->with('success', 'Session deleted successfully');
    }
}
