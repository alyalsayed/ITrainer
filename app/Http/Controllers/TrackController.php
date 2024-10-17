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

    // Assign users to a track form with pagination and search
    // Assign users to a track form with pagination and search

    // Assign users to a track form with search and pagination
    public function assignUsersForm($id, Request $request)
    {
        $track = Track::findOrFail($id);

        // Search functionality
        $query = User::query();
        if ($request->filled('search')) {
            $query->where('email', 'like', '%' . $request->input('search') . '%');
        }

        // Paginate results, 10 per page
        $users = $query->paginate(10);

        // Get already assigned users
        $assignedUsers = $track->users()->pluck('id')->toArray();

        return view('admin.tracks.assign', compact('track', 'users', 'assignedUsers'));
    }

    // Handle the user assignment/unassignment to a track
    public function assignUsers(Request $request, $id)
    {
        $track = Track::findOrFail($id);
        $userId = $request->input('user_id');

        // Check if the user is already assigned
        if ($track->users()->where('user_id', $userId)->exists()) {
            // Unassign the user if already assigned
            $track->users()->detach($userId);
            return response()->json(['status' => 'unassigned']);
        } else {
            // Assign the user if not assigned
            $track->users()->attach($userId);
            return response()->json(['status' => 'assigned']);
        }
    }
}
