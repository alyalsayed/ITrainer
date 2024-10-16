<?php

use App\Events\MessageSent;
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
use App\Http\Controllers\ChatController;
use App\Http\Controllers\NotificationController;
use App\Livewire\TodoList;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TrackController;


Route::get('/', function () {
    return view('welcome');
});


Route::middleware(['auth', 'update.last.seen'])->group(function () {
    Route::get('/chat/{receiver_id?}', [ChatController::class, 'index'])->name('chat.index');
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('chat.send');
    Route::get('/fetch-messages', [ChatController::class, 'fetchMessages'])->name('chat.fetch');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}/mark-as-read', [NotificationController::class, 'markAsRead'])->name('notifications.markAsRead');
    Route::get('/notifications/mark-all-as-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    Route::delete('notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
    Route::delete('notifications', [NotificationController::class, 'destroyAll'])->name('notifications.destroyAll');

    Route::get('/todo', TodoList::class)->name('todo.index');

});

// Admin routes
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    // User Management Routes
    Route::prefix('admin/users')->name('admin.users.')->group(function () {
        Route::get('/', [UserController::class, 'index'])->name('index');
        Route::get('/create', [UserController::class, 'create'])->name('create');
        Route::post('/', [UserController::class, 'store'])->name('store');
        Route::get('/{id}', [UserController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [UserController::class, 'edit'])->name('edit');
        Route::put('/{id}', [UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [UserController::class, 'destroy'])->name('destroy');
    });

    // Track Management Routes
    Route::prefix('admin/tracks')->name('admin.tracks.')->group(function () {
        Route::get('/', [TrackController::class, 'index'])->name('index');
        Route::get('/create', [TrackController::class, 'create'])->name('create');
        Route::post('/', [TrackController::class, 'store'])->name('store');
        Route::get('/{id}/edit', [TrackController::class, 'edit'])->name('edit');
        Route::put('/{id}', [TrackController::class, 'update'])->name('update');
        Route::delete('/{id}', [TrackController::class, 'destroy'])->name('destroy');

        // Route to assign users to tracks
        Route::get('/{id}/assign', [TrackController::class, 'assignUsersForm'])->name('assign');
        Route::post('/{id}/assign', [TrackController::class, 'assignUsers'])->name('assign.users');
});

});

// Instructor routes 
Route::middleware(['auth', 'role:instructor'])->group(function () {

    Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');

    // Session Routes
    Route::resource('sessions', SessionController::class); // Includes all CRUD operations

    // Task Routes
    // Route::resource('tasks', TaskController::class);

    Route::get('sessions/{session}/tasks', [TaskController::class, 'index'])->name('sessions.tasks.index');
    Route::get('sessions/{session}/tasks/create', [TaskController::class, 'create'])->name('sessions.tasks.create');
    Route::post('sessions/{session}/tasks', [TaskController::class, 'store'])->name('sessions.tasks.store');
    Route::get('sessions/{session}/tasks/{task}', [TaskController::class, 'show'])->name('sessions.tasks.show');
    Route::get('sessions/{session}/tasks/{task}/edit', [TaskController::class, 'edit'])->name('sessions.tasks.edit');
    Route::put('sessions/{session}/tasks/{task}', [TaskController::class, 'update'])->name('sessions.tasks.update');
    Route::delete('sessions/{session}/tasks/{task}', [TaskController::class, 'destroy'])->name('sessions.tasks.destroy');
    Route::get('sessions/{sessionId}/tasks/{taskId}/submissions/{submissionId}/grade', [TaskController::class, 'showGradeForm'])
        ->name('sessions.tasks.grade.form');

    // Route to handle the grading submission
    Route::post('sessions/{sessionId}/tasks/{taskId}/submissions/{submissionId}/grade', [TaskController::class, 'grade'])
        ->name('sessions.tasks.grade');


    // Attendance Routes
    Route::post('attendance/{sessionId}', [AttendanceController::class, 'storeAttendance'])->name('attendance.store');

    // Session Note Routes
    Route::post('sessions/{sessionId}/notes', [SessionNoteController::class, 'store'])->name('notes.store'); // Store new note for a session
    Route::put('sessions/{sessionId}/notes/{id}', [SessionNoteController::class, 'update'])->name('notes.update'); // Update existing note for a session
    Route::delete('sessions/{sessionId}/notes/{id}', [SessionNoteController::class, 'destroy'])->name('notes.destroy'); // Delete note for a session
    Route::post('/sessions/{sessionId}/notes/publish', [SessionNoteController::class, 'publish'])->name('notes.publish');


});

// Shared routes for both students and instructors
Route::middleware(['auth', 'role:student,instructor'])->group(function () {
    Route::get('sessions', [SessionController::class, 'index'])->name('sessions.index'); // View all sessions
    Route::get('sessions/{session}', [SessionController::class, 'show'])->name('sessions.show'); // View a single session
    Route::get('sessions/{session}/tasks', [TaskController::class, 'index'])->name('sessions.tasks.index');
    Route::get('sessions/{session}/tasks/{task}', [TaskController::class, 'show'])->name('sessions.tasks.show');

    Route::get('attendance/{sessionId}', [AttendanceController::class, 'showAttendanceForm'])->name('attendance.index');

    Route::get('sessions/{sessionId}/notes', [SessionNoteController::class, 'index'])->name('notes.index'); // List notes for a session


});
// Student routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
    Route::post('sessions/{session}/tasks/{task}/submit', [TaskController::class, 'submit'])->name('sessions.tasks.submit');
});
// HR routes
Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/hr/dashboard', [HrDashboardController::class, 'index'])->name('hr.dashboard');
});


require __DIR__ . '/auth.php';
