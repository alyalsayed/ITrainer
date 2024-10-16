<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     */
    public function index()
    {
        $users = User::all(); // Retrieve all users
        return view('admin.users.index', compact('users')); // Pass users to the view
    }

    /**
     * Show the form for creating a new user.
     */
    public function create()
    {
        return view('admin.users.create'); // Return the view to create a user
    }

    /**
     * Store a newly created or updated user in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'userType' => ['required', Rule::in(['admin', 'student', 'instructor', 'hr'])],
        ]);

        // Prepare data for upsert
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'userType' => $validated['userType'],
        ];

        // Upsert the user
        User::upsert([$data], ['email'], ['name', 'userType', 'password']);

        return redirect()->route('admin.users.index')->with('success', 'User created or updated successfully.');
    }

    /**
     * Display the specified user.
     */
    public function show(string $id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        return view('admin.users.show', compact('user')); // Pass user to the view
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(string $id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        return view('admin.users.edit', compact('user')); // Pass user to the view
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id); // Find the user by ID

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'userType' => ['required', Rule::in(['admin', 'student', 'instructor', 'hr'])],
        ]);

        // Prepare data for upsert
        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'userType' => $validated['userType'],
        ];

        // Only hash the password if it's being updated
        if ($validated['password']) {
            $data['password'] = Hash::make($validated['password']);
        }

        // Upsert the user
        User::upsert([$data], ['email'], ['name', 'userType', 'password']);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id); // Find the user by ID
        $user->delete(); // Delete the user
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }
}
