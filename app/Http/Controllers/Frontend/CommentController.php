<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class CommentController extends Controller
{



    public function store(Request $request)
    {
        if (Auth::check()) {
            $validator = Validator::make($request->all(), [
                'comment_body' => 'required|string',
                'is_deleted' => 'nullable'
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $post = Post::where('slug', $request->post_slug)->where('status', '0')->first();

            if ($post) {
                Comment::create([
                    'post_id' => $post->id,
                    'user_id' => Auth::user()->id,
                    'comment_body' => $request->comment_body

                ]);

                return redirect()->back()->with('message', 'Comment added successfully!');
            } else {
                return redirect()->back()->with('message', 'The post you are trying to comment on does not exist.');
            }
        } else {
            return redirect('login')->with('message', 'Please log in to post a comment.');
        }
    }

    public function destroy(Request $request)
{
    if (Auth::check()) {
        // Find the comment by ID and ensure it belongs to the authenticated user
        $comment = Comment::where('id', $request->comment_id)
                  ->where('user_id', Auth::id())
                  ->first();


        if ($comment) {
            // Set the is_deleted flag to 1
            $comment->is_deleted = 1;
            $comment->save();

            return response()->json([
                'status' => 200,
                'message' => 'Comment deleted successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 404,
                'message' => 'Comment not found or you do not have permission to delete it.'
            ]);
        }
    } else {
        return response()->json([
            'status' => 401,
            'message' => 'Login to delete this comment.'
        ]);
    }
}

}
