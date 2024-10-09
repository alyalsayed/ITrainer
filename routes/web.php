<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\HR\DashboardController;
use App\Http\Controllers\Admin\AdminHomeController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminTrackController;
use App\Http\Controllers\Instructor\SessionController;
use App\Http\Controllers\Admin\AdminSettingsController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\AdminAttendanceController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminSessionController; // Updated
use App\Http\Controllers\HR\DashboardController as HrDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Http\Controllers\Instructor\DashboardController as InstructorDashboardController;

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

// Admin Routes Group
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    // Admin Home Route
    Route::get('/', [AdminHomeController::class, '__invoke'])->name('home');

    // Admin Dashboard Route
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // User Management Resource Routes
    Route::get('/users/table', [AdminUserController::class, 'showUsersByType'])->name('users.table');

    Route::resource('users', AdminUserController::class)
        ->only(['index', 'show', 'update', 'create', 'destroy','store','edit']);

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

// HR routes
Route::middleware(['auth', 'role:hr'])->group(function () {
    Route::get('/hr/dashboard', [HrDashboardController::class, 'index'])->name('hr.dashboard');
});

// Instructor routes
Route::middleware(['auth', 'role:instructor'])->group(function () {
    Route::get('/instructor/dashboard', [InstructorDashboardController::class, 'index'])->name('instructor.dashboard');
    Route::resource('sessions',SessionController::class); // Ensure this references the instructor's SessionController
});

// Student routes
Route::middleware(['auth', 'role:student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

require __DIR__.'/auth.php';
