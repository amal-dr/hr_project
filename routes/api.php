<?php
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\ManagerController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\AttendanceController;
use App\Http\Controllers\VacationController;

Route::apiResource('employers', EmployerController::class);
Route::apiResource('managers', ManagerController::class);
Route::apiResource('apartments', ApartmentController::class);
Route::apiResource('tasks', TaskController::class);
Route::apiResource('attendances', AttendanceController::class);
Route::apiResource('vacations', VacationController::class);
