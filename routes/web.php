<?php

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