<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstitutionController;
use Illuminate\Http\Request; 

Route::get('/admin/institutions', [InstitutionController::class, 'index']);


Route::get('/', function () {
    return view('index');
});

Route::get('/admin/auth', function () {
    return view('admin.auth'); 
})->name('admin.auth');

Route::post('/admin/auth', function (Request $request) {
    // Verificar o codigo inserido e igual ao valor do .env
    if ($request->input('code') === env('ADMIN_CODE')) {
        // Redirecionar para o painel de admin se o código estiver correto
        return redirect()->route('admin.dashboard');
    }
    return back()->withErrors(['code' => 'Código de acesso incorreto.']);
})->name('admin.auth');

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

