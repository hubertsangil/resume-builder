<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ResumeController;
use App\Http\Controllers\ResumeBuilderController;
use App\Http\Controllers\PublicResumeController;

Route::get('/', function () {
    return redirect()->route('login');
});

// Auth
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.submit');

Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register'])->name('register.submit');

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Protected builder routes (require login)
Route::middleware('check.session')->group(function () {
    Route::get('/builder', [ResumeBuilderController::class, 'show'])->name('builder');
    Route::post('/builder', [ResumeBuilderController::class, 'store'])->name('builder.store');
});

// Public resume view (no auth required)
Route::get('/resume/{slug}', [PublicResumeController::class, 'show'])->name('resume.public');

// Old resume route (keep for backward compatibility if needed)
Route::get('/resume', [ResumeController::class, 'show'])->name('resume');
