<?php

namespace App\Http\Controllers\Admin;

use App\Models\Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AdminNotificationController extends Controller
{
    /**
     * Constructor to apply middleware for authorization
     */


    /**
     * Display notifications for the authenticated user
     */
    public function index()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('admin.notifications.index', compact('notifications'));
    }

    /**
     * Store a new notification
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Notification::create([
            'user_id' => $request->user_id,
            'type' => $request->type,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Notification created successfully');
    }

    /**
     * Mark a notification as read
     */
    public function markAsRead($id)
    {
        $notification = Notification::where('id', $id)
            ->where('user_id', Auth::id())
            ->firstOrFail();

        $notification->is_read = true;
        $notification->save();

        return redirect()->back()->with('success', 'Notification marked as read');
    }

    /**
     * Fetch notifications for the authenticated user (API)
     */
    public function fetchNotifications()
    {
        $notifications = Notification::where('user_id', Auth::id())
            ->where('is_read', false)
            ->latest()
            ->limit(5)
            ->get();

        return response()->json($notifications);
    }
}
