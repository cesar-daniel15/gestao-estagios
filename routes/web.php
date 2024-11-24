<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstitutionController;
use App\Http\Controllers\Api\CourseController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;

Route::get('/', function () { 
    return view('index'); 
});

// Rotas para instituições
Route::get('/admin/institutions', [InstitutionController::class, 'index'])->name('admin.institutions.index'); // Rota para listar todas as instituições
Route::get('/admin/institutions/{institution}', [InstitutionController::class, 'show'])->name('admin.institutions.show'); // Rota para mostrar uma instituição específica
Route::post('/admin/institutions', [InstitutionController::class, 'store'])->name('admin.institutions.store'); // Rota para criar uma nova instituição
Route::put('/admin/institutions/{institution}', [InstitutionController::class, 'update'])->name('admin.institutions.update'); // Rota para atualizar uma instituição
Route::delete('/admin/institutions/{institution}', [InstitutionController::class, 'destroy'])->name('admin.institutions.destroy'); // Rota para excluir uma instituição

// Rotas para cursos
Route::get('/admin/courses', [CourseController::class, 'index'])->name('admin.courses.index'); // Rota para listar todos os cursos
Route::get('/admin/courses/{course}', [CourseController::class, 'show'])->name('admin.courses.show'); // Rota para mostrar uma instituição específica
Route::put('/admin/courses/{course}', [CourseController::class, 'update'])->name('admin.courses.update'); // Rota para atualizar um curso
Route::post('/admin/courses', [CourseController::class, 'store'])->name('admin.courses.store'); // Rota para criar um curso
Route::delete('/admin/courses/{course}', [CourseController::class, 'destroy'])->name('admin.courses.destroy'); // Rota para excluir um curso

// Dashboard do admin
Route::get('/admin/dashboard', function () {
    return view('admin.dashboard'); 
})->name('admin.dashboard');

// Dashboard da instituição
Route::get('/institution/dashboard', function () {
    return view('institution.dashboard'); 
})->name('institution.dashboard');

// Dashboard da instituição
Route::get('/students/dashboard', function () {
    return view('students.dashboard'); 
})->name('students.dashboard');

// Rotas para login, registro, etc.
Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

// Outras rotas
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