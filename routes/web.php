<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use \App\Http\Middleware\EnsureAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return redirect('login');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::resource('tasks', TaskController::class)->except('show');
});

Route::middleware(['auth', EnsureAdmin::class])->group(function () {
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::get('/', [AdminController::class, 'index'])->name('dashboard');
        Route::resource('users', UserController::class)->except('show');
        Route::get('/reports',[ReportController::class,'task'])->name('reports.task');
        Route::post('/reports',[ReportController::class,'filterDate'])->name('reports.task.filterDate');
    });
});
