<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\AuthController;


Route::post('auth/register', [AuthController::class, 'create']);
Route::post('auth/login', [AuthController::class, 'login']);

Route::middleware(['auth:sanctum'])->group(function (){
    Route::resource('departments', DepartmentController::class);
    Route::resource('employees', EmployeeController::class);
    Route::get('employeesall', [EmployeeController::class, 'all']);
    Route::get('employeesbydepartment', [EmployeeController::class,
     'Employees ByDepartment']);
    Route::get('auth/logout', [AuthController::class, 'logout']);
});
