<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MusicController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ContactController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home'); // home.blade.php inside resources/views/
})->name('home');

// Admin Music Store Route
Route::post('/admin/store', [AdminController::class, 'store'])->name('admin.store');

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/browse', [HomeController::class, 'browse'])->name('browse');
Route::get('/music/{music}', [MusicController::class, 'show'])->name('music.show');

// ✅ FIX: Use POST for incrementPlay
Route::post('/music/{id}/play', [MusicController::class, 'incrementPlay'])->name('music.incrementPlay');

Route::get('/about', function () {
    return view('about');
})->name('about');

// Contact Routes (Outside of auth middleware)
Route::get('/contact', [ContactController::class, 'index'])->name('contact');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Dashboard
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});

// Admin Routes
Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.panel');
    Route::get('/admin/music/create', [AdminController::class, 'create'])->name('admin.music.create');
    Route::post('/admin/music', [AdminController::class, 'store'])->name('admin.music.store');
    Route::get('/admin/music/{id}/edit', [AdminController::class, 'edit'])->name('admin.music.edit');
    Route::put('/admin/music/{id}', [AdminController::class, 'update'])->name('admin.music.update');
    Route::delete('/admin/music/{id}', [AdminController::class, 'destroy'])->name('admin.music.destroy');

    // Admin Contact Messages
    Route::get('/admin/messages', [ContactController::class, 'messages'])->name('admin.messages');
    Route::delete('/admin/messages/{id}', [ContactController::class, 'destroy'])->name('admin.messages.delete');

    // Group all admin routes
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/panel', [AdminController::class, 'index'])->name('panel');
        Route::get('/create', [AdminController::class, 'create'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('/edit/{id}', [AdminController::class, 'edit'])->name('edit');
        Route::post('/update/{id}', [AdminController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [AdminController::class, 'destroy'])->name('destroy');
    });
});