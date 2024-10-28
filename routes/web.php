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

Route::get('/admin', function () {
    return view('admin.dashboard');
});

// Rota para a página da Instituição
Route::get('/instituicao', function () {
    return view('instituicao');
});

// Nova rota para a página da Empresa
Route::get('/empresa', function () {
    return view('empresa');
});

// Nova rota para a página da Empresa
Route::get('/coordenadores', function () {
    return view('coordenadores');
});

// Nova rota para a página da Empresa
Route::get('/aluno', function () {
    return view('aluno');
});