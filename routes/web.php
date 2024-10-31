<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstitutionController;


Route::get('/', function () {
    return view('index');
});

Route::get('/admin', function () {
    return view('admin.dashboard');
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

Route::get('/instituicao', function () {
    return view('instituicao');
});

Route::get('/empresa', function () {
    return view('empresa');
});

Route::get('/coordenadores', function () {
    return view('coordenadores');
});

Route::get('/aluno', function () {
    return view('aluno');
});
