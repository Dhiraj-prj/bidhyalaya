<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UsersController;
use App\Http\Controllers\Frontend\FrontendController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\ProgramController;
use Illuminate\Http\Request;


// Redirect root URL to frontend home page
Route::get('/', function () {
    return redirect('/home');
});



// Frontend Routes
Route::get('/home', [FrontendController::class, 'index']);
Route::get('program', [FrontendController::class, 'ViewProgram']);
Route::get('program/{Program_slug}', [FrontendController::class, 'ViewProgramPost']);
Route::get('posts', [FrontendController::class, 'ViewallPost']);
Route::get('program/{Program_slug}/{post_slug}', [FrontendController::class, 'ViewPost']);
Route::get('view-note/{note_id}', [FrontendController::class, 'viewNoteById'])->name('view.note.by.id');//route to view notes

//Comment System
Route::post('comments', [App\Http\Controllers\Frontend\CommentController::class,'store']);
Route::post('delete-comment',[App\Http\Controllers\Frontend\CommentController::class,'destroy']);

// Auth Routes
Route::get('register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('register-submit', [RegisterController::class, 'register'])->name('register.submit');
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('login-submit', [LoginController::class, 'login'])->name('login.submit');
Route::post('logout', [LoginController::class, 'logout'])->name('logout');

// Admin Routes
Route::prefix('admin')->middleware(['auth', 'isAdmin'])->group(function() {

    Route::get('/dashboard', [DashboardController::class, 'index']);

    // Program Routes
    Route::get('program', [ProgramController::class, 'index']);
    Route::get('add-program', [ProgramController::class, 'create']);
    Route::post('add-program', [ProgramController::class, 'store']);
    Route::get('edit-program/{Program_id}', [ProgramController::class, 'edit']);
    Route::put('update-program/{Program_id}', [ProgramController::class, 'update']);
    Route::get('delete-program/{Program_id}', [ProgramController::class, 'destroy']);

    // Post Routes
    Route::get('post', [PostController::class, 'index']);
    Route::get('add-post', [PostController::class, 'create'])->name('admin.add-post');
    Route::post('add-post', [PostController::class, 'store']);
    Route::get('edit-post/{post_id}', [PostController::class, 'edit']);
    Route::put('edit-post/{post_id}', [PostController::class, 'update']);
    Route::get('delete-post/{post_id}', [PostController::class, 'destroy']);
    Route::post('/admin/delete-file/{id}', [PostController::class, 'deleteFile'])->name('admin.delete-file');


    // User Routes
    Route::get('users', [UsersController::class, 'index']);
    Route::get('edit-users/{users_id}', [UsersController::class, 'edit']);
    Route::put('edit-users/{users_id}', [UsersController::class, 'update']);

    Route::get('settings', [SettingsController::class, 'index']); // Show the settings form
    Route::put('settings', [SettingsController::class, 'update']); // Handle the form submission

     // Get user details for AJAX request
    Route::get('get-user-details/{userId}', [UsersController::class, 'getUserDetails']);



   





});

// AJAX Route
Route::get('/admin/get-levels/{ProgramId}', [PostController::class, 'getLevels'])->name('admin.get-levels');


Route::get('/syllabus', function (Request $request) {
    $program = $request->query('program');

    $pdfs = [
        'BCA' => 'BCA_Syllabus.pdf',
        'BBS' => 'BBS syllabus.pdf',
        // Add other programs here if needed
    ];

    if (!isset($pdfs[$program])) {
        abort(404, 'Syllabus not found.');
    }

    return redirect('/' . $pdfs[$program]);
});