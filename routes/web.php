<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Hr\DashboardController as HrDashboardController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\SessionNoteController;
use App\Models\Quiz;
use App\Http\Controllers\QuizController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
});

// Instructor routes 
Route::middleware(['auth', 'role:instructor'])->group(function () {
    
    Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');
    
    // Session Routes
    Route::resource('sessions', SessionController::class); // Includes all CRUD operations

    // Task Routes
    Route::resource('tasks', TaskController::class);

    // Quiz Routes
    Route::resource('quizzes', QuizController::class);
    
    // Attendance Routes
    Route::get('attendance/{sessionId}', [AttendanceController::class, 'showAttendanceForm'])->name('attendance.index');
    Route::post('attendance/{sessionId}', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');
    
    // Session Note Routes
    Route::get('sessions/{sessionId}/notes', [SessionNoteController::class, 'index'])->name('notes.index');
    Route::get('sessions/{sessionId}/notes/create', [SessionNoteController::class, 'create'])->name('notes.create');
    Route::post('sessions/{sessionId}/notes', [SessionNoteController::class, 'store'])->name('notes.store');
    Route::get('notes/{id}', [SessionNoteController::class, 'show'])->name('notes.show');
    Route::get('notes/{id}/edit', [SessionNoteController::class, 'edit'])->name('notes.edit');
    Route::put('notes/{id}', [SessionNoteController::class, 'update'])->name('notes.update');
    Route::delete('notes/{id}', [SessionNoteController::class, 'destroy'])->name('notes.destroy');

});

// Shared routes for both students and instructors
Route::middleware(['auth', 'role:student,instructor'])->group(function () {
    Route::get('sessions', [SessionController::class, 'index'])->name('sessions.index'); // View all sessions
    Route::get('sessions/{session}', [SessionController::class, 'show'])->name('sessions.show'); // View a single session
});
// Student routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});
// HR routes
Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/hr/dashboard', [HrDashboardController::class, 'index'])->name('hr.dashboard');
});


require __DIR__ . '/auth.php';
