<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request; 
use App\Http\Middleware\DetectPostmanRequest;

Route::get('/', function () { return view('index'); });

Route::get('/admin/institutions', [InstitutionController::class, 'index'])->name('institutions.index');
Route::put('admin/institutions/{institution}', [InstitutionController::class, 'update'])->name('institutions.update');
Route::put('admin/institutions', [InstitutionController::class, 'destroy'])->name('institutions.destroy');

Route::get('/admin/users', [UserController::class, 'index']);

Route::post('/admin/auth', function (Request $request) {
    // Verificar o codigo inserido e igual ao valor do .env
    if ($request->input('code') === env('ADMIN_CODE')) {
        // Redirecionar para o painel de admin se o código estiver correto
        return redirect()->route('admin.dashboard');
    }
})->name('admin.auth');

Route::get('/admin/auth', function () {
    return view('admin.auth'); 
})->name('admin.auth');

Route::get('/', function () {
    return view('index');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); 
})->name('admin.dashboard');


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

