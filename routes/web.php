<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminInstitutionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCourseController;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckVerifiedAccount;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ResponsibleController;
use App\Http\Controllers\CompanyController;


Route::get('/', function () { 
    return view('index'); 
})->name('index');

// Rotas de Admin
Route::prefix('admin')->middleware(['auth', CheckVerifiedAccount::class])->group(function () {
    Route::get('/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::post('/users', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/institutions', [AdminInstitutionController::class, 'index'])->name('admin.institutions.index');
    Route::get('/institutions/{institution}', [AdminInstitutionController::class, 'show'])->name('admin.institutions.show');
    Route::post('/institutions', [AdminInstitutionController::class, 'store'])->name('admin.institutions.store');
    Route::put('/institutions/{institution}', [AdminInstitutionController::class, 'update'])->name('admin.institutions.update');
    Route::delete('/institutions/{institution}', [AdminInstitutionController::class, 'destroy'])->name('admin.institutions.destroy');

    Route::get('/courses', [AdminCourseController::class, 'index'])->name('admin.courses.index'); 
    Route::get('/courses/{course}', [AdminCourseController::class, 'show'])->name('admin.courses.show'); 
    Route::put('/courses/{course}', [AdminCourseController::class, 'update'])->name('admin.courses.update'); 
    Route::post('/courses', [AdminCourseController::class, 'store'])->name('admin.courses.store');
    Route::delete('/courses/{course}', [AdminCourseController::class, 'destroy'])->name('admin.courses.destroy'); 

    Route::get('/dashboard', function () {return view('admin.dashboard');})->name('admin.dashboard');
});

// Rotas para perfil de instituticao
Route::prefix('institution')->middleware(['auth', CheckVerifiedAccount::class])->group(function () {
    Route::get('/dashboard', [InstitutionController::class, 'index'])->name('institution.dashboard');
    Route::get('/profile', [InstitutionController::class, 'show'])->name('institution.profile');
    Route::post('/profile', [InstitutionController::class, 'store'])->name('institution.store');
});

// Rotas para perfil de aluno
Route::prefix('student')->middleware(['auth', CheckVerifiedAccount::class])->group(function () {
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
});

// Rotas para perfil de responsaveis pela uc
Route::prefix('responsible')->middleware(['auth', CheckVerifiedAccount::class])->group(function () {
    Route::get('/dashboard', [ResponsibleController::class, 'index'])->name('responsible.dashboard');
});

// Rotas para perfil de empresa
Route::prefix('company')->middleware(['auth', CheckVerifiedAccount::class])->group(function () {
    Route::get('/dashboard', [CompanyController::class, 'index'])->name('company.dashboard');
});

// Rotas de auth
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('verify-account', [AuthController::class, 'verifyToken'])->name('verify.account');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/register', function () {
    return view('auth.register');
});

Route::get('/verify-account', function () {
    return view('auth.verify-account');
})->name('verify-account');

Route::get('/reset-password', function () {
    return view('auth.reset-password');
});

Route::get('/forgot-password', function () {
    return view('auth.forgot-password');
})->name('forgot-password');

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
