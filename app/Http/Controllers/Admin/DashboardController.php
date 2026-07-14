<?php
namespace App\Http\Controllers\Admin;

use App\Models\Program;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        // Pending counts
        $pendingPosts = Post::where('hideStatus', '0')->count(); // Adjust based on your model
        $pendingUsers = User::where('status', '0')->count(); // Correct the model to User

        // Total counts (existing)
        $categories = Program::count();
        $posts = Post::where('is_deleted', '0')->count(); // Filter deleted posts
        $users = User::where('role_as', '0')->count(); // Adjust for regular users
        $admins = User::where('role_as', '1')->count(); // Admin users

        // Additional data
        $recentPosts = Post::orderBy('created_at', 'desc')->take(5)->get(); // 5 recent posts
        $recentUsers = User::orderBy('created_at', 'desc')->take(5)->get(); // 5 most recent users

        // Program posts data for chart
        $categoriesData = Program::withCount('posts')->get();

        // Returning data to view
        return view('admin.dashboard', compact(
            'categories', 'posts', 'users', 'admins', 'recentPosts', 'pendingPosts', 'pendingUsers', 'recentUsers', 'categoriesData'
        ));
    }
}
