<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Track;
use App\Models\User;


class TrackController extends Controller
{
    // List all tracks
    public function index()
    {
        $tracks = Track::all();
        return view('admin.tracks.index', compact('tracks'));
    }

    // Show form to create a new track
    public function create()
    {
        return view('admin.tracks.create');
    }

    // Store a new track
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        Track::create($validated);

        return redirect()->route('admin.tracks.index')->with('success', 'Track created successfully.');
    }

    // Edit an existing track
    public function edit($id)
    {
        $track = Track::findOrFail($id);
        return view('admin.tracks.edit', compact('track'));
    }

    // Update a track
    public function update(Request $request, $id)
    {
        $track = Track::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $track->update($validated);

        return redirect()->route('admin.tracks.index')->with('success', 'Track updated successfully.');
    }

    // Delete a track
    public function destroy($id)
    {
        $track = Track::findOrFail($id);
        $track->delete();

        return redirect()->route('admin.tracks.index')->with('success', 'Track deleted successfully.');
    }

    // Show the form to assign users to a track
    public function assignUsersForm($id)
    {
        $track = Track::findOrFail($id);
        $users = User::all(); // You can filter this if needed

        return view('admin.tracks.assign', compact('track', 'users'));
    }

    // Assign users to a track
    public function assignUsers(Request $request, $id)
    {
        $track = Track::findOrFail($id);
        $validated = $request->validate([
            'users' => 'required|array',
        ]);

        // Sync users to the track (attach or replace)
        $track->users()->sync($validated['users']);

        return redirect()->route('admin.tracks.index')->with('success', 'Users assigned to track successfully.');
    }
}
