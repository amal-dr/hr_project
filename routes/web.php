<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\Manager\EmployeeController as ManagerEmployeeController;
use App\Http\Controllers\Manager\TaskController as ManagerTaskController;

// Employer Authentication Routes
Route::middleware('guest:employer')->group(function () {
    Route::controller(EmployerController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('login');
        Route::post('/login', 'login');
    });
});

// Employer Protected Routes
Route::middleware(['auth:employer', 'verified'])->group(function () { // Added 'verified' middleware
    Route::controller(EmployerController::class)->group(function () {
        // Dashboard
        Route::get('/dashboard', 'dashboard')->name('dashboard');
        
        // Attendance
        Route::prefix('attendance')->group(function () {
            Route::post('/record', 'recordAttendance')->name('attendance.record');
            Route::get('/history', 'getAttendanceHistory')->name('attendance.history');
        });
        
        // Tasks
        Route::put('/tasks/{task}/update', 'updateTask')->name('task.update');
        
        // Vacation
        Route::prefix('vacation')->group(function () {
            Route::get('/request', 'showVacationRequestForm')->name('vacation.request');
            Route::post('/store', 'storeVacationRequest')->name('vacation.store');
        });
        
        // Profile
        Route::get('/profile', 'profile')->name('profile');
        
        // Logout
        Route::match(['get', 'post'], '/logout', 'logout')->name('logout');
    });
});

// Manager Authentication Routes
Route::middleware('guest:manager')->prefix('manager')->group(function () {
    Route::controller(ManagerController::class)->group(function () {
        Route::get('/login', 'showLoginForm')->name('manager.login');
        Route::post('/login', 'login');
    });
});

// Manager Protected Routes
Route::middleware(['auth:manager', 'manager.active'])->prefix('manager')->group(function () { // Added custom 'manager.active' middleware
    Route::controller(ManagerController::class)->group(function () {
        Route::get('/dashboard', 'dashboard')->name('manager.dashboard');
        
        // Vacation requests
        Route::prefix('vacation')->group(function () {
            Route::post('/{id}/approve', 'approveVacation')->name('manager.vacation.approve');
            Route::post('/{id}/reject', 'rejectVacation')->name('manager.vacation.reject');
        });
    });
    
    // Employee management (resource controller)
    Route::resource('/employees', ManagerEmployeeController::class);
    
    // Task management (resource controller)
    Route::resource('/tasks', ManagerTaskController::class);
});

// Home Redirect
Route::redirect('/', '/login');