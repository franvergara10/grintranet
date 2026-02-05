<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SocialAuthController;

use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\HolidayController;
use App\Http\Controllers\ScheduleTemplateController;
use App\Http\Controllers\ZonaController;
use App\Http\Controllers\AusenciaController;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'loginView'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset Routes
Route::get('forgot-password', [PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [PasswordResetController::class, 'reset'])->name('password.update');

// Google Auth Routes
Route::get('auth/google', [SocialAuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('auth/google/callback', [SocialAuthController::class, 'handleGoogleCallback']);

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\GroupController;
use App\Http\Controllers\DashboardController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');

    // Group routes
    Route::resource('groups', GroupController::class);

    // Only admins can manage users and roles
    Route::middleware(['role:admin'])->group(function () {
        Route::get('users/import', [\App\Http\Controllers\ImportController::class, 'index'])->name('users.import');
        Route::post('users/import', [\App\Http\Controllers\ImportController::class, 'import'])->name('users.import.process');
        
        Route::resource('users', UserController::class);
        Route::resource('roles', RoleController::class);
        Route::resource('zonas', ZonaController::class);
    });

    // Calendar Routes
    Route::get('/calendar', [HolidayController::class, 'index'])->name('calendar.index');
    
    // Management routes for directiva/admin
    Route::middleware(['role:admin|directiva'])->group(function () {
        Route::post('/holidays', [HolidayController::class, 'store'])->name('holidays.store');
        Route::delete('/holidays/{holiday}', [HolidayController::class, 'destroy'])->name('holidays.destroy');
    });

    // Schedule Templates
    Route::resource('schedule-templates', ScheduleTemplateController::class);
    Route::get('schedule-templates/{id}/preview', [ScheduleTemplateController::class, 'preview'])->name('schedule-templates.preview');

    // Personal Schedules
    Route::resource('personal-schedules', \App\Http\Controllers\PersonalScheduleController::class);

    // Ausencias
    Route::resource('ausencias', AusenciaController::class);
});
