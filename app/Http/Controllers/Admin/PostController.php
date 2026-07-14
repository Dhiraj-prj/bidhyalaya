<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\PostFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Program;
use App\Http\Requests\Admin\PostFormRequest;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::where('is_deleted', false)->where('hideStatus',0)->get();

        return view('admin.post.index', compact('posts'));
    }

    public function create()
    {
        // Fetch programs that are active (hideStatus = 0) and not deleted
        $programs = Program::where('hideStatus', 0)->where('is_deleted', 0)->get();

        // Pass the programs to the Blade view
        return view('admin.post.create', compact('programs'));
    }

    public function store(PostFormRequest $request)
    {

        // Validate the request data
        $data = $request->validated();

        // Create the new post
        $post = new Post();
        $post->Program_id = $data['Program_id'];
        $post->subProgram = $data['subProgram'];
        $post->name = $data['name'];
        $post->slug = $this->generateSlug($data['name'], $data['slug'] ?? null);
        $post->description = $data['description'] ?? null;
        $post->postType = $data['postType'] ?? null;
        $post->yt_iframe = $data['yt_iframe'] ?? null;
        $post->meta_title = $data['meta_title'] ?? null;
        $post->meta_description = $data['meta_description'] ?? null;
        $post->meta_keyword = $data['meta_keyword'] ?? null;
        $post->hideStatus = $request->has('hideStatus') ? 1 : 0;
        $post->created_by = Auth::user()->id;
        $post->save();

        // Handle file uploads
        if ($request->has('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('post_files', 'public'); // Store file in 'post_files' folder
                PostFile::create([
                    'post_id' => $post->id,
                    'file_path' => $path,
                    'file_name' => $file->getClientOriginalName(),
                ]);
            }
        }

        // Redirect after post creation
        return redirect('admin/post')->with('message', 'Post created successfully.');
    }

    public function edit($post_id)
    {
        // Find the post by ID and return with programs
        $post = Post::find($post_id);
        if (!$post) {
            return view('admin.post.edit')->with('error', 'Post not found!');
        }

        $programs = Program::all();
        return view('admin.post.edit', compact('post', 'programs'));
    }

    public function update(Request $request, $postId)
    {
        $post = Post::find($postId);
        if (!$post) {
            return redirect('admin/posts')->with('error', 'Post not found!');
        }

        // Update post details
        $post->name = $request->name;
        $post->Program_id = $request->Program_id;
        $post->subProgram = $request->subProgram;
        $post->postType = $request->postType;
        $post->slug = $request->slug;
        $post->description = $request->description;
        $post->meta_title = $request->meta_title;
        $post->meta_description = $request->meta_description;
        $post->meta_keyword = $request->meta_keyword;
        $post->hideStatus = $request->hideStatus ? 1 : 0;  // Set as 1 if checked, otherwise 0
        $post->save();

        // Handle file uploads if any
        if ($request->hasFile('files')) {
            $files = $request->file('files');
            foreach ($files as $file) {
                if ($file->isValid()) {
                    // Store file in the public disk and get the path
                    $path = $file->store('uploads/posts', 'public');
                    Log::info('File uploaded successfully: ' . $path);  // Debug log to check file upload

                    // Create a new PostFile record
                    $post->files()->create([
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                    ]);
                } else {
                    Log::error('File upload failed.');
                }
            }
        }

        // Fetch updated posts and programs to pass to the view
        $posts = Post::where('is_deleted', false)->get();
        $programs = Program::all();

        return view('admin.post.index', compact('posts', 'programs'))->with('success', 'Post updated successfully');
    }

    public function destroy($post_id)
    {
        $post = Post::findOrFail($post_id);
        $post->is_deleted = true; // Soft delete
        $post->update();

        return redirect('admin/post')->with('destroy_message', 'Post deleted successfully.');
    }

    // File removal method
    public function removeFile($post_id, $file_id)
    {
        $postFile = PostFile::findOrFail($file_id);

        // Delete file from storage
        Storage::delete($postFile->file_path);

        // Delete record from the database
        $postFile->delete();

        return back()->with('message', 'File removed successfully.');
    }

    // File viewing method
    public function viewFile(PostFile $file)
    {
        $filePath = storage_path("app/{$file->file_path}");

        // Check if the file exists
        if (file_exists($filePath)) {
            return response()->file($filePath);
        } else {
            return redirect()->back()->with('error', 'File not found.');
        }
    }

    public function getLevels($ProgramId)
    {
        // Fetch Program using ProgramId
        $Program = Program::find($ProgramId);

        if (!$Program) {
            return response()->json(['error' => 'Program not found'], 404); // Return error if Program not found
        }

        $levels = [];
        if ($Program->levelType == 1) { // Semester type
            $levels = [
                ['id' => 1, 'name' => 'Semester I'],
                ['id' => 2, 'name' => 'Semester II'],
                ['id' => 3, 'name' => 'Semester III'],
                ['id' => 4, 'name' => 'Semester IV'],
                ['id' => 5, 'name' => 'Semester V'],
                ['id' => 6, 'name' => 'Semester VI'],
                ['id' => 7, 'name' => 'Semester VII'],
                ['id' => 8, 'name' => 'Semester VIII'],
            ];
        } elseif ($Program->levelType == 2) { // Year type
            $levels = [
                ['id' => 1, 'name' => 'Year I'],
                ['id' => 2, 'name' => 'Year II'],
                ['id' => 3, 'name' => 'Year III'],
                ['id' => 4, 'name' => 'Year IV'],
            ];
        }

        return response()->json($levels); // Return levels as JSON
    }

    private function generateSlug($name, $slug = null)
    {
        $slug = $slug ?? Str::slug($name); // Use the provided slug or generate it from the name

        // Check if the slug already exists in the database
        $originalSlug = $slug;
        $count = Post::where('slug', $slug)->count();

        // Append a number to make the slug unique
        if ($count > 0) {
            $slug = $originalSlug . '-' . ($count + 1);
        }

        return $slug;
    }

    public function deleteFile(Request $request, $id)
{
    $file = PostFile::find($id); // Ensure you're using the correct model
    if ($file) {
        Storage::delete('public/' . $file->file_path); // Delete from storage
        $file->delete(); // Remove from database

        return response()->json(['success' => true]);
    }

    return response()->json(['success' => false, 'message' => 'File not found']);
}


}
