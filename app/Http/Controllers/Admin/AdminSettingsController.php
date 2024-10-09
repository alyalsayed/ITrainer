<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Setting;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Hash;

class AdminSettingsController extends Controller
{
    /**
     * Constructor to apply middleware for authorization
     */

    /**
     * Display the settings page
     */
    public function index()
    {
        $settings = Setting::all();
        return view('admin.settings.index', compact('settings'));
    }

    /**
     * Show the general settings page
     */
    public function generalSettings()
    {
        $settings = Setting::all();
        return view('admin.settings.general', compact('settings'));
    }

    /**
     * Show the notification settings page
     */
    public function notificationSettings()
    {
        $settings = Setting::all();
        return view('admin.settings.notifications', compact('settings'));
    }

    /**
     * Fetch unread notifications for the authenticated user
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
     * Store the newly created setting
     */
    public function store(Request $request)
    {
        $request->validate([
            'key' => 'required|unique:settings,key',
            'value' => 'required',
        ]);

        Setting::create($request->only('key', 'value'));

        return redirect()->route('admin.settings.index')->with('success', 'Setting created successfully');
    }

    /**
     * Show the form to edit a setting
     */
    public function edit($id)
    {
        $setting = Setting::findOrFail($id);
        return view('admin.settings.edit', compact('setting'));
    }

    /**
     * Update a specific setting
     */
    public function update(Request $request, $id)
    {
        $setting = Setting::findOrFail($id);

        $request->validate([
            'value' => 'required',
        ]);

        $setting->update($request->only('value'));

        return redirect()->route('admin.settings.index')->with('success', 'Setting updated successfully');
    }

    /**
     * Update Password
     */
    public function updatePassword(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        // Fetch the authenticated user
        $user = Auth::user();

        // Debugging output
        if (is_null($user)) {
            return redirect()->route('admin.settings.index')->withErrors(['current_password' => 'User not authenticated.']);
        } else {
            // Optionally, you can log user information for debugging
            Log::info('Authenticated user:', ['user' => $user]);
        }

        // Verify the current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->route('admin.settings.index')->withErrors(['current_password' => 'Current password is incorrect.']);
        }

        // Update the user's password
        $user->password = Hash::make($request->new_password);

        // Attempt to save the user
        if ($user->save()) {
            return redirect()->route('admin.settings.index')->with('success', 'Password updated successfully');
        } else {
            return redirect()->route('admin.settings.index')->withErrors(['error' => 'Failed to update password.']);
        }
    }


}
