<?php

use App\Http\Controllers\Api\Admin\AdminController;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Subscriber\SubscriberController;
use App\Http\Controllers\Api\Worker\WorkerController;
use Illuminate\Support\Facades\Route;
 
/*
|--------------------------------------------------------------------------
| Public Routes (no auth required)
|--------------------------------------------------------------------------
*/
Route::prefix('auth')->group(function () {
    Route::post('/register',      [AuthController::class, 'register']);
    Route::post('/login',         [AuthController::class, 'login']);
    Route::post('/social-login',  [AuthController::class, 'socialLogin']);
});
 
/*
|--------------------------------------------------------------------------
| Protected Routes — must be authenticated + active
|--------------------------------------------------------------------------
*/
Route::middleware(['auth:sanctum', 'active'])->group(function () {
 
    // ── Shared (all authenticated users) ──────────────────────────────
    Route::prefix('auth')->group(function () {
        Route::get('/me',          [AuthController::class, 'me']);
        Route::post('/logout',     [AuthController::class, 'logout']);
        Route::post('/logout-all', [AuthController::class, 'logoutAll']);
    });
 
    // ── Admin only ────────────────────────────────────────────────────
    Route::middleware('role:website_admin')
        ->prefix('admin')
        ->group(function () {
            Route::get('/dashboard',        [AdminController::class, 'dashboard']);
            Route::get('/users',            [AdminController::class, 'listUsers']);
            Route::patch('/users/{id}/role',[AdminController::class, 'changeRole']);
            Route::patch('/users/{id}/toggle-active', [AdminController::class, 'toggleActive']);
            Route::delete('/users/{id}',    [AdminController::class, 'deleteUser']);
        });
 
    // ── Admin + Worker ────────────────────────────────────────────────
    Route::middleware('role:website_admin,website_worker')
        ->prefix('worker')
        ->group(function () {
            Route::get('/dashboard',   [WorkerController::class, 'dashboard']);
        });
 
    // ── Subscriber (all roles can access their own profile) ───────────
    Route::middleware('role:website_admin,website_worker,website_subscriber')
        ->prefix('subscriber')
        ->group(function () {
            Route::get('/profile',    [SubscriberController::class, 'profile']);
            Route::patch('/profile',  [SubscriberController::class, 'updateProfile']);
        });
});
