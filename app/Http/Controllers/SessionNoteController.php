<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrackSession;
use App\Models\SessionNote;

class SessionNoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($sessionId)
    {
        $session = TrackSession::findOrFail($sessionId);
        $notes = $session->notes;
        return view('notes.index', compact('session', 'notes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($sessionId)
    {
        $session = TrackSession::findOrFail($sessionId);
        return view('notes.create', compact('session'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $sessionId)
    {
        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,code,screenshot',
            'content' => $request->type === 'screenshot' ? 'nullable' : 'required'
        ]);
    
        $note = new SessionNote();
        $note->session_id = $sessionId;
        $note->title = $request->title;
        $note->type = $request->type;
    
        // Handle content based on the type
        if ($request->type === 'screenshot' && $request->hasFile('content')) {
            // Store image
            $path = $request->file('content')->store('images', 'public');
            $note->content = $path;
        } else {
            // Store text or code
            $note->content = $request->content;
        }
    
        $note->save();
    
        return redirect()->route('notes.index', $sessionId)->with('success', 'Note created successfully.');
    }
    
    public function update(Request $request, $id)
    {
        // Validate the request, including the note type
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:text,code,screenshot',
            'content' => $request->type === 'screenshot' ? 'nullable' : 'required'
        ]);
    
        $note = SessionNote::findOrFail($id);
        $note->title = $request->title;
        $note->type = $request->type; // Update the type
    
        // Handle content based on the updated type
        if ($note->type === 'screenshot') {
            if ($request->hasFile('content')) {
                // Store the new image if uploaded
                $path = $request->file('content')->store('images', 'public');
                $note->content = $path;
            } else {
                // Keep existing image if no new one is uploaded
                $note->content = $note->content; // This keeps the current content
            }
        } else {
            // Store text or code
            $note->content = $request->content;
        }
    
        $note->save();
    
        return redirect()->route('notes.index', $note->session_id)->with('success', 'Note updated successfully.');
    }
    
    
    

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $note = SessionNote::findOrFail($id);
        return view('notes.edit', compact('note'));
    }

    /**
     * Update the specified resource in storage.
     */
    
    
    



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $note = SessionNote::findOrFail($id);
        $note->delete();

        return redirect()->back()->with('success', 'Note deleted successfully.');
    }
}
