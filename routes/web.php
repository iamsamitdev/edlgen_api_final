<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

// หน้าหลักของเว็บไซต์
Route::get('/', function () {
    return view('home');
});

// หน้าเกี่ยวกับเรา (About Us)
Route::get('/about', function () {
    return view('about');
});

// หน้าติดต่อเรา (Contact Us)
Route::get('/contact', function () {
    return view('contact');
});

// ── ล็อกอิน/ล็อกเอาต์ (session-based, สำหรับหน้าเว็บ dashboard) ──
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});
Route::post('/logout', [LoginController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

// ── Dashboard แจ้งเหตุ (ต้องล็อกอินก่อนเข้าใช้งาน) ──
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});