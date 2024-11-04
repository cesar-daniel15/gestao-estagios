<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\InstitutionController; // Import do Controller Institution


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Rota para a API de InstitutionController
Route::get('institutions', [InstitutionController::class, 'index'])->name('institutions.index');  // Para listar todas as instituições 
Route::get('institutions/{id}', [InstitutionController::class, 'show'])->name('institutions.show');  // Para mostrar uma instituição específica
Route::post('institutions', [InstitutionController::class, 'store'])->name('institutions.store'); // Para criar uma nova instituição
Route::put('institutions/{id}', [InstitutionController::class, 'update'])->name('institutions.update');  // Para atualizar uma instituição existente
Route::delete('institutions/{id}', [InstitutionController::class, 'destroy'])->name('institutions.destroy');  // Para apagar uma instituição
