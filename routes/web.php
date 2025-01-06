<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminInstitutionController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminCourseController;
use App\Http\Controllers\Admin\AdminUnitsCurricularsController;
use App\Http\Controllers\Admin\AdminUcResponsibleController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\AdminStudentController;
use App\Http\Controllers\Admin\AdminCompanyController;
use App\Http\Controllers\Admin\AdminInternshipOffersController;
use App\Http\Controllers\Admin\AdminInternshipPlansController;
use App\Http\Controllers\Admin\AdminAttendanceRecordsController;
use App\Http\Controllers\Admin\AdminFinalReportsController;
use Illuminate\Http\Request;
use App\Http\Middleware\CheckVerifiedAccount;
use App\Http\Middleware\CheckProfileCompletion;
use App\Http\Controllers\ContactController;
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

    Route::get('/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

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

    Route::get('/units-curriculars', [AdminUnitsCurricularsController::class, 'index'])->name('admin.units.index');
    Route::get('/units-curriculars/{unitCurricular}', [AdminUnitsCurricularsController::class, 'show'])->name('admin.units.show');
    Route::put('/units-curriculars/{unitCurricular}', [AdminUnitsCurricularsController::class, 'update'])->name('admin.units.update');
    Route::post('/units-curriculars', [AdminUnitsCurricularsController::class, 'store'])->name('admin.units.store');
    Route::delete('/units-curriculars/{unitCurricular}', [AdminUnitsCurricularsController::class, 'destroy'])->name('admin.units.destroy');

    Route::get('/uc-responsibles', [AdminUcResponsibleController::class, 'index'])->name('admin.uc_responsibles.index');
    Route::get('/uc-responsibles/{UcResponsible}', [AdminUcResponsibleController::class, 'show'])->name('admin.uc_responsibles.show');
    Route::put('/uc-responsibles/{UcResponsible}', [AdminUcResponsibleController::class, 'update'])->name('admin.uc_responsibles.update');
    Route::post('/uc-responsibles', [AdminUcResponsibleController::class, 'store'])->name('admin.uc_responsibles.store');
    Route::delete('/uc-responsibles/{UcResponsible}', [AdminUcResponsibleController::class, 'destroy'])->name('admin.uc_responsibles.destroy');
    Route::post('/uc-responsibles/{UcResponsible}/associate-uc', [AdminUcResponsibleController::class, 'associateUc'])->name('admin.uc_responsibles.associate_uc');

    Route::get('/students', [AdminStudentController::class, 'index'])->name('admin.students.index');
    Route::get('/students/{student}', [AdminStudentController::class, 'show'])->name('admin.students.show');
    Route::put('/students/{student}', [AdminStudentController::class, 'update'])->name('admin.students.update');
    Route::post('/students', [AdminStudentController::class, 'store'])->name('admin.students.store');
    Route::delete('/students/{student}', [AdminStudentController::class, 'destroy'])->name('admin.students.destroy');
    Route::post('/students/{student}/associate-uc', [AdminStudentController::class, 'associateStudentToUc'])->name('admin.students.associateStudentToUc');

    Route::get('/notifications', [AdminNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::get('/notifications/{notification}', [AdminNotificationController::class, 'show'])->name('admin.notifications.show');
    Route::put('/notifications/{notification}', [AdminNotificationController::class, 'update'])->name('admin.notifications.update');
    Route::post('/notifications', [AdminNotificationController::class, 'store'])->name('admin.notifications.store');
    Route::delete('/notifications/{notification}', [AdminNotificationController::class, 'destroy'])->name('admin.notifications.destroy');

    Route::get('/companies', [AdminCompanyController::class, 'index'])->name('admin.companies.index');
    Route::get('/companies/{company}', [AdminCompanyController::class, 'show'])->name('admin.companies.show');
    Route::post('/companies', [AdminCompanyController::class, 'store'])->name('admin.companies.store');
    Route::put('/companies/{company}', [AdminCompanyController::class, 'update'])->name('admin.companies.update');
    Route::delete('/companies/{company}', [AdminCompanyController::class, 'destroy'])->name('admin.companies.destroy');

    Route::get('/internships-offers', [AdminInternshipOffersController::class, 'index'])->name('admin.internships_offers.index');
    Route::get('/internships-offers/{internship_offer}', [AdminInternshipOffersController::class, 'show'])->name('admin.internships_offers.show');
    Route::post('/internships-offers', [AdminInternshipOffersController::class, 'store'])->name('admin.internships_offers.store');
    Route::put('/internships-offers/{internship_offer}', [AdminInternshipOffersController::class, 'update'])->name('admin.internships_offers.update');
    Route::delete('/internships-offers/{internship_offer}', [AdminInternshipOffersController::class, 'destroy'])->name('admin.internships_offers.destroy');
    Route::post('/internships-offers/close', [AdminInternshipOffersController::class, 'closeOffer'])->name('admin.internships_offers.close');
    Route::get('/internship-offers/{id}/download', [AdminInternshipOffersController::class, 'download'])->name('admin.internship_offers.download');

    Route::get('/internships-plans', [AdminInternshipPlansController::class, 'index'])->name('admin.internships_plans.index');
    Route::get('/internships-plans/{internship_plan}', [AdminInternshipPlansController::class, 'show'])->name('admin.internships_plans.show');
    Route::post('/internships-plans', [AdminInternshipPlansController::class, 'store'])->name('admin.internships_plans.store');
    Route::put('/internships-plans/{internship_plan}', [AdminInternshipPlansController::class, 'update'])->name('admin.internships_plans.update');
    Route::delete('/internships-plans/{internship_plan}', [AdminInternshipPlansController::class, 'destroy'])->name('admin.internships_plans.destroy');

    Route::get('/attendance-records', [AdminAttendanceRecordsController::class, 'index'])->name('admin.internship_attendance_records.index');
    Route::get('/attendance-records/{attendance_record}', [AdminAttendanceRecordsController::class, 'show'])->name('admin.internship_attendance_records.show');
    Route::post('/attendance-records', [AdminAttendanceRecordsController::class, 'store'])->name('admin.internship_attendance_records.store');
    Route::put('/attendance-records/{attendance_record}', [AdminAttendanceRecordsController::class, 'update'])->name('admin.internship_attendance_records.update');
    Route::delete('/attendance-records/{attendance_record}', [AdminAttendanceRecordsController::class, 'destroy'])->name('admin.internship_attendance_records.destroy');

    Route::get('/final-reports', [AdminFinalReportsController::class, 'index'])->name('admin.internship_final_reports.index');
    Route::get('/final-reports/{final_report}', [AdminFinalReportsController::class, 'show'])->name('admin.internship_final_reports.show');
    Route::post('/final-reports', [AdminFinalReportsController::class, 'store'])->name('admin.internship_final_reports.store');
    Route::put('/final-reports/{final_report}', [AdminFinalReportsController::class, 'update'])->name('admin.internship_final_reports.update');
    Route::delete('/final-reports/{final_report}', [AdminFinalReportsController::class, 'destroy'])->name('admin.internship_final_reports.destroy');
    Route::get('/final-reports/{final_report}/download', [AdminFinalReportsController::class, 'download'])->name('admin.internship_final_reports.download');

});

// Rotas para perfil de instituticao
Route::prefix('institution')->middleware(['auth', CheckVerifiedAccount::class, CheckProfileCompletion::class])->group(function () {
    Route::get('/dashboard', [InstitutionController::class, 'index'])->name('institution.dashboard');
    Route::get('/profile', [InstitutionController::class, 'show'])->name('institution.profile');
    Route::post('/profile', [InstitutionController::class, 'store'])->name('institution.store');
    Route::get('/courses', [InstitutionController::class, 'listCourses'])->name('institution.courses');
    Route::get('/units-curriculars', [InstitutionController::class, 'listUcs'])->name('institution.units');
    Route::get('/uc-responsibles', [InstitutionController::class, 'listUcResponsible'])->name('institution.uc_responsibles');
    Route::get('/students', [InstitutionController::class, 'listStudents'])->name('institution.students');
    Route::get('/internships', [InstitutionController::class, 'listInternships'])->name('institution.internships');
    Route::post('/internships/{internship_offer}', [InstitutionController::class, 'finalEvaluation'])->name('institution.finalEvaluation');
});

// Rotas para perfil de aluno
Route::prefix('student')->middleware(['auth', CheckVerifiedAccount::class, CheckProfileCompletion::class])->group(function () {
    Route::get('/dashboard', [StudentController::class, 'index'])->name('student.dashboard');
    Route::post('/dashboard/{notification}', [StudentController::class, 'readNotification'])->name('student.notification');
    Route::post('/dashboard', [StudentController::class, 'storeAttendance'])->name('student.storeAttendance');
    Route::get('/profile', [StudentController::class, 'show'])->name('student.profile');
    Route::post('/profile', [StudentController::class, 'store'])->name('student.store');
    Route::get('/internships/download', [StudentController::class, 'download'])->name('student.internship.download');
    Route::get('/internships', [StudentController::class, 'listInternships'])->name('student.internships');
    Route::post('/internships/apply/{internship_offer}', [StudentController::class, 'applyInternships'])->name('student.internships.apply');
    Route::post('/internships/remove/{internship_offer}', [StudentController::class, 'removeInternships'])->name('student.internships.remove');
    Route::get('/reports', [StudentController::class, 'listReports'])->name('student.reports');
    Route::post('/reports', [StudentController::class, 'storeReports'])->name('student.reports.store');
});

// Rotas para perfil de responsaveis pela uc
Route::prefix('responsible')->middleware(['auth', CheckVerifiedAccount::class, CheckProfileCompletion::class])->group(function () {
    Route::get('/dashboard', [ResponsibleController::class, 'index'])->name('responsible.dashboard');
    Route::get('/profile', [ResponsibleController::class, 'show'])->name('responsible.profile');
    Route::post('/profile', [ResponsibleController::class, 'store'])->name('responsible.store');
    Route::get('/students', [ResponsibleController::class, 'listStudents'])->name('responsible.students');
    Route::post('/students', [ResponsibleController::class, 'storeStudent'])->name('responsible.students.create');
    Route::put('/students/{student}', [ResponsibleController::class, 'updateStudent'])->name('responsible.students.update');
    Route::delete('/students/{student}', [ResponsibleController::class, 'destroyStudent'])->name('responsible.students.destroy');
    Route::get('/internships', [ResponsibleController::class, 'listInternships'])->name('responsible.internships');
    Route::post('/internships/{internship_plan}', [ResponsibleController::class, 'agreeInternships'])->name('responsible.internships.agree');
    Route::post('/internships/{internship_offer}/associate', [ResponsibleController::class, 'associateInternships'])->name('responsible.internships.associate');
    Route::get('/export', [ResponsibleController::class, 'listExportFiles'])->name('responsible.export.list');
    Route::get('/export/download', [ResponsibleController::class, 'downloadExportFiles'])->name('responsible.export.downlad');
    Route::get('/notifications',[ResponsibleController::class, 'listNotifications'])->name('responsible.notifications');
    Route::post('/notifications',[ResponsibleController::class, 'storeNotifications'])->name('responsible.notifications.storeNotifications');
});

// Rotas para perfil de empresa
Route::prefix('company')->middleware(['auth', CheckVerifiedAccount::class, CheckProfileCompletion::class])->group(function () {
    Route::get('/dashboard', [CompanyController::class, 'index'])->name('company.dashboard');
    Route::get('/profile', [CompanyController::class, 'show'])->name('company.profile');
    Route::post('/profile', [CompanyController::class, 'store'])->name('company.store');
    Route::get('/internships', [CompanyController::class, 'listInternships'])->name('company.internships'); 
    Route::post('/internships', [CompanyController::class, 'storeInternships'])->name('company.internships.store'); 
    Route::post('/internships/close', [CompanyController::class, 'closeOffer'])->name('company.internships.close');
    Route::get('/plans', [CompanyController::class, 'listPlans'])->name('company.plans');
    Route::post('/plans', [CompanyController::class, 'storePlan'])->name('company.plans.store');
    Route::get('/attendance', [CompanyController::class, 'listAttendance'])->name('company.attendance');
    Route::post('/attendance/{attendance_record}', [CompanyController::class, 'approveAttendance'])->name('company.attendance.approve');
    Route::get('/evaluations', [CompanyController::class, 'listEvaluations'])->name('company.evaluations');
    Route::post('/evaluations/{final_report}', [CompanyController::class, 'storeEvaluations'])->name('company.evaluations.store');
});

// Rotas de auth
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('login', [AuthController::class, 'login'])->name('login');
Route::post('logout', [AuthController::class, 'logout'])->name('logout');
Route::post('verify-account', [AuthController::class, 'verifyToken'])->name('verify.account');
Route::post('forgot-password', [AuthController::class, 'forgotPassword'])->name('forgot.password');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'resetPassword'])->name('password.update');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');


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

Route::get('/contact', function () {
    return view('contact');
})->name('contact');
