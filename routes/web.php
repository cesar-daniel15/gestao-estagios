<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

Route::get('/', function () { 
    return view('index'); 
});

Route::get('/admin/institutions', [InstitutionController::class, 'index'])->name('admin.institutions.index'); // Rota para mostrar todas as intituicoes
Route::get('/admin/institutions/{institution}', [InstitutionController::class, 'show'])->name('admin.institutions.show'); // Rota para mostrar uma instituicao específica
Route::post('/admin/institutions', [InstitutionController::class, 'store'])->name('admin.institutions.store'); // Rota para criar uma nova instituicao
Route::put('/admin/institutions/{institution}', [InstitutionController::class, 'update'])->name('admin.institutions.update'); // Rota para atualizar uma instituicao
Route::delete('/admin/institutions/{institution}', [InstitutionController::class, 'destroy'])->name('admin.institutions.destroy'); // Rota para excluir uma instituicao

// Outras rotas do admin
Route::get('/admin/users', [UserController::class, 'index'])->name('admin.users');

// Dashboard do admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); 
})->name('admin.dashboard');

// Outras rotas de login, registro e etc.
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
