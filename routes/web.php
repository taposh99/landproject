<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PropertyController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/properties', [PropertyController::class, 'index'])->name('properties.index');
Route::get('/property/{slug}', [PropertyController::class, 'show'])->name('properties.show');
Route::get('/converter', [HomeController::class, 'converter'])->name('converter');
Route::get('/api/upazilas', [HomeController::class, 'getUpazilas'])->name('api.upazilas');
Route::get('/api/unions', [HomeController::class, 'getUnions'])->name('api.unions');
Route::get('/api/villages', [HomeController::class, 'getVillages'])->name('api.villages');

// Public Inquiry submission (works for both guests & logged-in users)
Route::post('/property/{property}/inquiry', [PropertyController::class, 'submitInquiry'])->name('properties.inquiry');

// Guest Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

// Authenticated User Routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    // Land Posting & Management
    Route::get('/post-land', [PropertyController::class, 'create'])->name('properties.create');
    Route::post('/post-land', [PropertyController::class, 'store'])->name('properties.store');
    Route::get('/my-properties', [PropertyController::class, 'myProperties'])->name('my.properties');
    Route::post('/property/{property}/sold', [PropertyController::class, 'markAsSold'])->name('properties.sold');
    Route::post('/property/{property}/favorite', [PropertyController::class, 'toggleFavorite'])->name('properties.favorite');
});

// Admin Panel Routes
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminController::class, 'dashboard'])->name('dashboard');
    Route::post('/properties/{property}/approve', [AdminController::class, 'approve'])->name('properties.approve');
    Route::post('/properties/{property}/reject', [AdminController::class, 'reject'])->name('properties.reject');
    Route::post('/properties/{property}/toggle-verify', [AdminController::class, 'toggleVerify'])->name('properties.toggle-verify');
    Route::post('/properties/{property}/toggle-feature', [AdminController::class, 'toggleFeature'])->name('properties.toggle-feature');
    Route::delete('/properties/{property}', [AdminController::class, 'destroy'])->name('properties.destroy');
    Route::get('/users', [AdminController::class, 'users'])->name('users');
});
