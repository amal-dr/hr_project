<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ManagerController;

// Authentication Routes
Route::middleware('guest:employer')->group(function () {
    Route::get('/login', [EmployerController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [EmployerController::class, 'login']);
});

Route::middleware(['auth:employer'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [EmployerController::class, 'dashboard'])->name('dashboard');
    
    // Attendance
    Route::post('/attendance/record', [EmployerController::class, 'recordAttendance'])->name('attendance.record');
    Route::get('/attendance/history', [EmployerController::class, 'getAttendanceHistory'])->name('attendance.history');
    
    // Tasks
    Route::put('/tasks/{task}/update', [EmployerController::class, 'updateTask'])->name('task.update');
    
    // Vacation
    Route::get('/vacation/request', [EmployerController::class, 'showVacationRequestForm'])->name('vacation.request');
    Route::post('/vacation/store', [EmployerController::class, 'storeVacationRequest'])->name('vacation.store');
    
    // Profile
    Route::get('/profile', [EmployerController::class, 'profile'])->name('profile');
    
    // Logout
    Route::post('/logout', [EmployerController::class, 'logout'])->name('logout');
    Route::get('/logout', [EmployerController::class, 'logout']);
});

Route::get('/', function () {
    return redirect('/login');
});













// Authentication routes
Route::get('/manager/login', [ManagerController::class, 'showLoginForm'])->name('manager.login');
Route::post('/manager/login', [ManagerController::class, 'login']);

// Protected routes
Route::middleware(['auth:manager'])->group(function () {
    Route::get('/manager/dashboard', [ManagerController::class, 'dashboard'])->name('manager.dashboard');
    
    // Employee management
    Route::resource('/manager/employees', ManagerEmployeeController::class);
    
    // Vacation requests
    Route::post('/manager/vacation/{id}/approve', [ManagerController::class, 'approveVacation'])->name('manager.vacation.approve');
    Route::post('/manager/vacation/{id}/reject', [ManagerController::class, 'rejectVacation'])->name('manager.vacation.reject');
    
    // Task management
    Route::resource('/manager/tasks', ManagerTaskController::class);
});