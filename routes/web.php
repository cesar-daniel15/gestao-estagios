<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstitutionController;

Route::get('/admin/institutions', [InstitutionController::class, 'index']);

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

<<<<<<< HEAD
Route::get('/admin', function () {
    return view('admin.dashboard');
=======
Route::get('/verify-acount', function () {
    return view('auth.verify-acount');
>>>>>>> 43091eae3410411d12143835a74df128f5166bd7
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
<<<<<<< HEAD
});
=======
});



>>>>>>> 43091eae3410411d12143835a74df128f5166bd7
