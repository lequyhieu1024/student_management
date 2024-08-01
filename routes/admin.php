<?php

use App\Http\Controllers\Admin\DepartmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\TransriptController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::get('/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard');

Route::resource('students', StudentController::class);
Route::resource('departments', DepartmentController::class);
Route::resource('subjects', SubjectController::class);
Route::resource('transcripts', TransriptController::class);
