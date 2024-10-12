<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\TrackSession;
use App\Models\SessionNote;
use Illuminate\Support\Facades\Storage;
use  App\Notifications\NotesPublished;
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
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $sessionId)
    {
        $contentRule = $request->type === 'screenshot' ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|string';
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:text,code,screenshot',
            'content' => $contentRule,
        ]);


        $note = new SessionNote();
        $note->title = $request->title;
        $note->type = $request->type;

        if ($request->type == 'screenshot') {

            if ($request->hasFile('content')) {
                $path = $request->file('content')->store('notes/images', 'public');
                $note->content = $path;
            }
        } else {

            $note->content = $request->content;
        }

        $note->session_id = $sessionId;
        $note->save();

        return redirect()->route('notes.index', $sessionId)->with('success', 'Note added successfully!');
    }



    public function update(Request $request, $sessionId, $noteId)
    {
        $contentRule = $request->type === 'screenshot' ? 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048' : 'required|string';
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|string|in:text,code,screenshot',
            'content' => $contentRule,
        ]);


        $note = SessionNote::findOrFail($noteId);
        $note->title = $request->title;
        $note->type = $request->type;

        if ($request->type === 'screenshot') {
            if ($request->hasFile('content')) {
                // Delete the old image if necessary
                Storage::disk('public')->delete($note->content); // Delete the old image from storage
                $path = $request->file('content')->store('notes/images', 'public'); // Store the new image
                $note->content = $path; // Update the path in the database
            } else {
                // If no new image is uploaded, retain the old image path
                $note->content = $note->content; // Keep the old content
            }
        } else {
            $note->content = $request->content; // Save text/code content directly
        }

        $note->save();

        return redirect()->route('notes.index', $sessionId)->with('success', 'Note updated successfully!');
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy($sessionId, $id)
    {
        // Fetch the session and note
        $session = TrackSession::findOrFail($sessionId);
        $note = $session->notes()->findOrFail($id);

        // Delete the note's image if it exists
        if ($note->type === 'screenshot' && $note->content && Storage::disk('public')->exists($note->content)) {
            Storage::disk('public')->delete($note->content);
        }

        // Delete the note
        $note->delete();

        return redirect()->route('notes.index', $sessionId)->with('success', 'Note deleted successfully!');
    }
    public function publish(Request $request, $sessionId)
    {
        // Find the session
        $session = TrackSession::findOrFail($sessionId);

        // Notify all students in the session's track
        $students = $session->track->users()->where('userType', 'student')->get();

        foreach ($students as $student) {
                $student->notify(new NotesPublished( $session));
        }

        return redirect()->route('notes.index', $sessionId)->with('success', 'Notes published and students notified successfully!');
    }
}
