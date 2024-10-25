<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('index');
});

Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
});

Route::get('/verify-acount', function () {
    return view('auth.verify-acount');
});


Route::get('/admin', function () {
    return view('admin.dashboard');
});

Route::get('/admin/users', function () {
    return view('admin.users');
});

Route::get('/admin/institutions', function () {
    return view('admin.institutions');
});

