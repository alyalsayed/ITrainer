<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminUserController extends Controller
{
    /**
     * Display a listing of the users based on type with pagination and search.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
        {
            $user = Auth::user();

            if (!$user) {
                return redirect()->route('admin.dashboard')->with('error', 'Unauthorized access.');
            }

            // Check if the user's userType is 'admin'
            if ($user->userType !== 'admin') {
                return redirect()->route('admin.dashboard')->with('error', 'Unauthorized access.');
            }


            // Default counts for analytics
            $studentCount = User::where('userType', 'student')->count();
            $instructorCount = User::where('userType', 'instructor')->count();
            $hrCount = User::where('userType', 'hr')->count();
            $adminCount = User::where('userType', 'admin')->count();

            return view('admin.users.index', compact( 'studentCount', 'instructorCount', 'hrCount', 'adminCount'));
        }




    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $userTypes = ['admin', 'student', 'instructor', 'hr'];
        return view('admin.users.create', compact('userTypes'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validTypes = ['admin', 'student', 'instructor', 'hr'];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'userType' => ['required', 'string', Rule::in($validTypes)],
            'password' => 'required|confirmed|min:8',
        ]);

        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'userType' => $request->input('userType'),
            'password' => Hash::make($request->input('password')),
        ]);

        return redirect()->route('admin.users.index', ['type' => $request->input('userType')])
                         ->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user's details.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $userTypes = ['admin', 'student', 'instructor', 'hr'];
        return view('admin.users.edit', compact('user', 'userTypes'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validTypes = ['admin', 'student', 'instructor', 'hr'];

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => [
                'required',
                'email',
                'max:255',
                Rule::unique('users')->ignore($user->id),
            ],
            'userType' => ['required', 'string', Rule::in($validTypes)],
            'password' => 'nullable|confirmed|min:8',
        ]);

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->userType = $request->input('userType');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->input('password'));
        }

        $user->save();

        return redirect()->route('admin.users.index', ['type' => $user->userType])
                         ->with('success', 'User updated successfully.');
    }

    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        // Prevent admins from deleting their own account
        if (Auth::id() === $user->id) {
            return redirect()->back()->with('error', 'You cannot delete your own account.');
        }

        $userType = $user->userType; // Store userType before deletion

        $user->delete();

        return redirect()->route('admin.users.index', ['type' => $userType])
                         ->with('success', 'User deleted successfully.');
    }

    // UserController.php

    public function showUsersByType(Request $request)
{
    $validTypes = ['admin', 'student', 'instructor', 'hr'];
    $type = $request->input('type');

    // Validate the user type
    if (!in_array($type, $validTypes)) {
        return redirect()->route('admin.users.index')->with('error', 'Invalid user type.');
    }

    $users = User::where('userType', $type)->get();
    return view('admin.users.table', compact('users', 'type'));
}


}
