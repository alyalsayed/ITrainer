<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HR\DashboardController as HrDashboardController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminTrackController;
use App\Http\Controllers\Instructor\SessionController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminSessionController; // Updated
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\SessionNoteController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\TaskController;
use App\Livewire\TodoList;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/chat', function () {
//     broadcast(new MessageSent());
// });

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

// Admin Routes Group
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Admin Home Route
    Route::get('/', [AdminHomeController::class, '__invoke'])->name('home');

    // Admin Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management Resource Routes
    Route::get('/users/table', [AdminUserController::class, 'showUsersByType'])->name('users.table');
    Route::resource('users', AdminUserController::class)
        ->only(['index', 'show', 'update', 'create', 'destroy', 'store', 'edit']);

    // Admin Settings Routes
    Route::resource('settings', AdminSettingsController::class)->only(['index', 'update']);
    Route::put('/password/update', [AdminSettingsController::class, 'updatePassword'])->name('password.update');
    Route::put('/settings/{id}', [AdminSettingsController::class, 'update'])->name('settings.update');

    // Additional Setting Routes
    Route::get('/settings/general', [AdminSettingsController::class, 'generalSettings'])->name('settings.general');

    // Admin Notifications Routes
    Route::resource('notifications', AdminNotificationController::class)->only(['index']);
    Route::get('/notifications/fetch', [AdminNotificationController::class, 'fetchNotifications'])->name('notifications.fetch');
    Route::put('/notifications/{id}/read', [AdminNotificationController::class, 'markAsRead'])->name('notifications.markAsRead');

    // Admin Track Resource Routes
    Route::resource('tracks', AdminTrackController::class);

    // Admin Sessions Resource Routes (nested within tracks)
    Route::resource('tracks.sessions', AdminSessionController::class);

    // Attendance Routes (nested within sessions and tracks)
    Route::resource('tracks.sessions.attendance', AdminAttendanceController::class)
        ->only(['index', 'create', 'store', 'destroy']);
});

// Instructor routes 
Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');
    Route::resource('sessions', SessionController::class); // Includes all CRUD operations

    // Task Routes
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

