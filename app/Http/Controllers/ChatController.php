<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Events\MessageSent;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ChatController extends Controller
{

// Display chat view
public function index($receiver_id = null) {
    // Fetch the currently authenticated user
    $currentUser = Auth::user();

    try {
        // Get the user's current track IDs using the pivot relationship
        $trackIds = $currentUser->tracks()->pluck('tracks.id'); // Assuming 'tracks' is the name of the relationship
   
        // Fetch all users in the same tracks, except the authenticated user
        $users = User::where('id', '!=', $currentUser->id)
            ->whereIn('id', function($query) use ($trackIds) {
                $query->select('user_id')
                      ->from('track_user') // Replace with your actual pivot table name
                      ->whereIn('track_id', $trackIds);
            })
            ->get();
         

        // Ensure that the receiver_id is valid
        $receiver = $receiver_id ? User::find($receiver_id) : null; // No user selected

    } catch (\Exception $e) {
        abort(404);
    }

    return view($receiver ? 'chat.chatroom' : 'chat.index', compact('users', 'receiver_id', 'receiver'));
}



public function sendMessage(Request $request) {
    $message = Message::create([
        'sender_id' => Auth::id(),
        'receiver_id' => $request->receiver_id, 
        'message' => $request->message,
    ]);

    $message->load('sender');
    broadcast(new MessageSent($message))->toOthers();

    return response()->json(['status' => 'Message Sent!', 'message' => $message]);

}


public function fetchMessages(Request $request) {
    $messages = Message::with('sender') // Eager load the sender relationship
        ->where(function($query) use ($request) {
            $query->where('sender_id', Auth::id())
                  ->orWhere('receiver_id', Auth::id());
        })
        ->where(function($query) use ($request) {
            $query->where('sender_id', $request->receiver_id)
                  ->orWhere('receiver_id', $request->receiver_id);
        })
        ->get();

    return response()->json($messages);
}




}
