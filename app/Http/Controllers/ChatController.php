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
    // Fetch all users except the authenticated user
    try {
        $users = User::where('id', '!=', Auth::user()->id)->get();
        
        // Ensure that the receiver_id is valid
        if ($receiver_id) {
            $receiver = User::find($receiver_id);
        } else {
            $receiver = null; // No user selected
        }

    } catch (\Exception $e) {
        abort(404);
    }
    
    if ($receiver) {
        return view('chat.chatroom', compact('users', 'receiver_id', 'receiver'));
    }

    return view('chat.index', compact('users', 'receiver_id', 'receiver'));
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
