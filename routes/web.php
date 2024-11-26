<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\InstitutionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckVerifiedAccount;

Route::get('/', function () { 
    return view('index'); 
});

Route::prefix('admin')->middleware(['auth', CheckVerifiedAccount::class])->group(function () {
    Route::get('/users', [UserController::class, 'index'])->name('admin.users.index');
    Route::get('/users/{user}', [UserController::class, 'show'])->name('admin.users.show');
    Route::put('/users/{user}', [UserController::class, 'update'])->name('admin.users.update');
    Route::delete('/users/{user}', [UserController::class, 'destroy'])->name('admin.users.destroy');

    Route::get('/institutions', [InstitutionController::class, 'index'])->name('admin.institutions.index');
    Route::get('/institutions/{institution}', [InstitutionController::class, 'show'])->name('admin.institutions.show');
    Route::post('/institutions', [InstitutionController::class, 'store'])->name('admin.institutions.store');
    Route::put('/institutions/{institution}', [InstitutionController::class, 'update'])->name('admin.institutions.update');
    Route::delete('/institutions/{institution}', [InstitutionController::class, 'destroy'])->name('admin.institutions.destroy');

    Route::get('/courses', [CourseController::class, 'index'])->name('admin.courses.index'); 
    Route::get('/courses/{course}', [CourseController::class, 'show'])->name('admin.courses.show'); 
    Route::put('/courses/{course}', [CourseController::class, 'update'])->name('admin.courses.update'); 
    Route::post('/courses', [CourseController::class, 'store'])->name('admin.courses.store');
    Route::delete('/courses/{course}', [CourseController::class, 'destroy'])->name('admin.courses.destroy'); 

    Route::get('/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');
});

Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('verify-account', [AuthController::class, 'verifyToken'])->name('verify.account');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');


Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
})->name('admin.dashboard')->middleware(['auth']);

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


// Dashboard da instituição
Route::get('/institution/dashboard', function () {
    return view('institution.dashboard'); 
})->name('institution.dashboard');

// Dashboard do Student
Route::get('/student/dashboard', function () {
    return view('student.dashboard'); 
})->name('student.dashboard');

// Dashboard do Responsible
Route::get('/responsible/dashboard', function () {
    return view('responsible.dashboard'); 
})->name('responsible.dashboard');

// Dashboard do Company
Route::get('/company/dashboard', function () {
    return view('company.dashboard'); 
})->name('company.dashboard');