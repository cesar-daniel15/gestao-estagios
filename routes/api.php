<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\InstitutionController; // Import do Controller Institution
use App\Http\Controllers\Api\CourseController; // Import do Controller Course


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Grupo das rotas de InstitutionController
Route::prefix('institutions')->group(function () {
    Route::get('/', [InstitutionController::class, 'index'])->name('institutions.index');  // Listar todas as instituições
    Route::get('{id}', [InstitutionController::class, 'show'])->name('institutions.show');  // Mostrar uma instituição específica
    Route::post('/', [InstitutionController::class, 'store'])->name('institutions.store'); // Criar uma nova instituição
    Route::put('{id}', [InstitutionController::class, 'update'])->name('institutions.update');  // Atualizar uma instituição existente
    Route::delete('{id}', [InstitutionController::class, 'destroy'])->name('institutions.destroy');  // Apagar uma instituição
});

// Grupo das rotas de CourseController
Route::prefix('courses')->group(function () {
    Route::get('/', [CourseController::class, 'index'])->name('courses.index');  // Listar todos os cursos 
    Route::get('{id}', [CourseController::class, 'show'])->name('courses.show');  // Mostrar um curso específico
    Route::post('/', [CourseController::class, 'store'])->name('courses.store'); // Criar um novo curso
    Route::put('{id}', [CourseController::class, 'update'])->name('courses.update');  // Atualizar um curso existente
    Route::delete('{id}', [CourseController::class, 'destroy'])->name('courses.destroy');  // Apagar um curso
});