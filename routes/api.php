<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController; // Import do Controller User
use App\Http\Controllers\Admin\InstitutionController; // Import do Controller Institution
use App\Http\Controllers\Admin\CourseController; // Import do Controller Course
use App\Http\Controllers\Admin\CompanyController; // Import do Controller Companie
use App\Http\Controllers\Admin\UcResponsibleController; // Import do Controller UcResponsible
use App\Http\Controllers\Admin\StudentController; // Import do Controller User
use App\Http\Controllers\AuthController; // Import do Controller Auth

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::post('/register',[AuthController::class,'register']);

Route::post('/login', [AuthController::class, 'login']);  // Fazer Login

// Grupo das rotas de UserController
Route::prefix('users')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('users.index');  // Listar todas os users
    Route::get('{user}', [UserController::class, 'show'])->name('users.show');  // Mostrar um user específico
    Route::post('/', [UserController::class, 'store'])->name('users.store'); // Criar uma novo user
    Route::put('{user}', [UserController::class, 'update'])->name('users.update');  // Atualizar um user existente
    Route::delete('{user}', [UserController::class, 'destroy'])->name('users.destroy');  // Apagar um user
});

// Grupo das rotas de InstitutionController
Route::prefix('institutions')->group(function () {
    Route::get('/', [InstitutionController::class, 'index'])->name('institutions.index');  // Listar todas as instituições
    Route::get('{institution}', [InstitutionController::class, 'show'])->name('institutions.show');  // Mostrar uma instituição específica
    Route::post('/', [InstitutionController::class, 'store'])->name('institutions.store'); // Criar uma nova instituição
    Route::put('{institution}', [InstitutionController::class, 'update'])->name('institutions.update');  // Atualizar uma instituição existente
    Route::delete('{institution}', [InstitutionController::class, 'destroy'])->name('institutions.destroy');  // Apagar uma instituição
});

// Grupo das rotas de CourseController
Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');  // Listar todos os cursos 
    Route::get('{course}', [CourseController::class, 'show'])->name('courses.show');  // Mostrar um curso específico
    Route::post('/', [CourseController::class, 'store'])->name('courses.store'); // Criar um novo curso
    Route::put('{course}', [CourseController::class, 'update'])->name('courses.update');  // Atualizar um curso existente
    Route::delete('{course}', [CourseController::class, 'destroy'])->name('courses.destroy');  // Apagar um curso
});

// Grupo das rotas de CompanyController
Route::prefix('companies')->group(function () {
    Route::get('/', [CompanyController::class, 'index'])->name('companies.index');  // Listar todos as empresa 
    Route::get('{company}', [CompanyController::class, 'show'])->name('companies.show');  // Mostrar uma empresa em específico
    Route::post('/', [CompanyController::class, 'store'])->name('companies.store'); // Criar uma nova empresa
    Route::put('{company}', [CompanyController::class, 'update'])->name('companies.update');  // Atualizar uma empresa existente
    Route::delete('{company}', [CompanyController::class, 'destroy'])->name('companies.destroy');  // Apagar uma empresa
});

// Grupo das rotas de Responsaveis da UC
Route::prefix('uc-responsibles')->group(function () {
    Route::get('/', [UcResponsibleController::class, 'index'])->name('uc-responsibles.index');  // Listar todos os responsaveis 
    Route::get('uc_responsible}', [UcResponsibleController::class, 'show'])->name('uc-responsibles.show');  // Mostrar um resposanvel especifico
    Route::post('/', [UcResponsibleController::class, 'store'])->name('uc-responsibles.store'); // Criar uma novo responsavel
    Route::put('{uc_responsible}', [UcResponsibleController::class, 'update'])->name('uc-responsibles.update');  // Atualizar um resposanval existente
    Route::delete('{uc_responsible}', [UcResponsibleController::class, 'destroy'])->name('uc-responsibles.destroy');  // Apagar um resposanvel
});

// Grupo das rotas de StudentController
Route::prefix('students')->group(function () {
    Route::get('/', [StudentController::class, 'index'])->name('students.index');  // Listar todos os alunos 
    Route::get('student}', [StudentController::class, 'show'])->name('students.show');  // Mostrar um aluno em específicos
    Route::post('/', [StudentController::class, 'store'])->name('students.store'); // Criar uma novo aluno
    Route::put('{student}', [StudentController::class, 'update'])->name('students.update');  // Atualizar um aluno existente
    Route::delete('{student}', [StudentController::class, 'destroy'])->name('students.destroy');  // Apagar uma aluno
});
