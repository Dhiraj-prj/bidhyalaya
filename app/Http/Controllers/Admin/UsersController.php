<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UsersController extends Controller
{
    // Display all users
    public function index() {
        // Check users who haven't logged in for 3 months and update their status to 1
        $this->updateUserStatus();

        $users = User::all();
        return view('admin.users.index', compact('users'));
    }

    // Show the edit form for a specific user
    public function edit($users_id) {
        $user = User::find($users_id);

        if (!$user) {
            return redirect('admin/users')->with('error', 'User not found!');
        }

        return view('admin.users.edit', compact('user'));
    }

    // Update the user data
    public function update(Request $request, $users_id) {
        // Validate the incoming request
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $users_id,  // Ensure unique email except for this user
            'phone' => 'nullable|string|max:15',
            'dob' => 'nullable|date',
            'role_as' => 'required|in:1,0',  // Only allow 1 or 2 for roles
            'status' => 'nullable|in:0,1',  // Status can be 0 (inactive) or 1 (active)
        ]);

        // Find the user by ID
        $user = User::find($users_id);

        if (!$user) {
            return redirect('admin/users')->with('error', 'User not found!');
        }

        // Update the user's data
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->dob = $request->input('dob');
        $user->role_as = $request->input('role_as');
        $user->status = $request->input('status', 0); // Default status is 0 if not provided

        // Save the updated user
        $user->save();

        // Redirect back to the users list with a success message
        return redirect('admin/users')->with('message', 'User updated successfully!');
    }

    // Get user details for the AJAX request
    public function getUserDetails($userId)
    {
        // Find the user by ID
        $user = User::find($userId);

        // Check if user exists
        if ($user) {
            return response()->json([
                'success' => true,
                'user' => $user
            ]);
        } else {
            return response()->json([
                'success' => false
            ]);
        }
    }

    // Method to automatically change the user's status to 1 if they haven't logged in for 3 months
    private function updateUserStatus()
    {
        $threeMonthsAgo = Carbon::now()->subMonths(3);

        // Get users who haven't logged in for 3 months and have a status of 0
        $users = User::where('status', 0)
                    ->where('last_login_at', '<', $threeMonthsAgo)
                    ->get();

        foreach ($users as $user) {
            $user->status = 1; // Set status to 1
            $user->save();
        }
    }
}
