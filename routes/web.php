<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\AdminJobController;
use App\Http\Middleware\IsAdmin;

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

// Public Routes
Route::get('/', function () {
    return view('welcome');
})->name('home');

// Authentication Routes
Route::middleware('guest')->group(function() {
    Route::controller(AuthController::class)->group(function() {
        Route::get('/register', 'registerForm')->name('register');
        Route::post('/register', 'register')->middleware('throttle:3,1');
        Route::get('/login', 'loginForm')->name('login');
        Route::post('/login', 'login')->middleware('throttle:5,1');
    });
});

// Authenticated User Routes
Route::middleware('auth')->group(function() {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    
    // Job Routes
    Route::resource('jobs', JobController::class)->except(['index']);
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
});

// Admin Routes
Route::middleware(['auth', IsAdmin::class])->group(function() {
    Route::prefix('admin')->name('admin.')->controller(AdminJobController::class)->group(function() {
        Route::get('/', 'dashboard')->name('dashboard');
        Route::get('/jobs', 'index')->name('jobs.index');
        Route::post('/jobs/bulk-action', 'bulkAction')->name('jobs.bulk-action')
            ->middleware('throttle:10,1');
        Route::post('/jobs/{id}/approve', 'approve')->name('jobs.approve');
        Route::post('/jobs/{id}/reject', 'reject')->name('jobs.reject');
        Route::delete('/jobs/{id}', 'destroy')->name('jobs.destroy');
    });
});