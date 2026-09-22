<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BloodAdminController;
use App\Http\Controllers\BloodDonorController;
use App\Http\Controllers\BloodHomeController;
use App\Http\Controllers\BloodPageController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\ContactUsQueryController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\RequirerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDetailController;
use Illuminate\Support\Facades\Route;

// Portfolio (same blade — several URLs)
Route::get('/', fn () => redirect()->route('home'));
Route::get('/home', fn () => view('portfolio', ['section' => 'home']))->name('home');
Route::get('/portfolio', fn () => view('portfolio', ['section' => 'home']))->name('portfolio');
Route::get('/work', fn () => view('portfolio', ['section' => 'work']))->name('work');
Route::get('/about', fn () => view('portfolio', ['section' => 'about']))->name('about');
Route::get('/contact', fn () => view('portfolio', ['section' => 'contact']))->name('contact');

// Student password admin
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');
Route::middleware('admin')->group(function () {
    Route::get('/admin/students', [AdminController::class, 'students'])->name('admin.students');
    Route::get('/admin', [AdminController::class, 'students'])->name('admin.index');
    Route::delete('/admin/students/{student}', [AdminController::class, 'destroy'])->name('admin.students.destroy');
});

Route::get('/student', [StudentController::class, 'create'])->name('student.create');
Route::post('/student', [StudentController::class, 'store'])->name('student.store');
Route::get('/student-details', [StudentDetailController::class, 'create'])->name('student-details.create');
Route::post('/student-details', [StudentDetailController::class, 'store'])->name('student-details.store');

// Blood donation system (assignment view folders)
Route::get('/blood', [BloodHomeController::class, 'index'])->name('blood.home');

Route::get('/blood/donors', [BloodDonorController::class, 'index'])->name('blood.donors');
Route::get('/blood/donors/create', [BloodDonorController::class, 'create'])->name('blood.donor.create');
Route::post('/blood/donors', [BloodDonorController::class, 'store'])->name('blood.donor.store');

Route::get('/blood/requests', [RequirerController::class, 'index'])->name('blood.requests');
Route::get('/blood/requests/create', [RequirerController::class, 'create'])->name('blood.request.create');
Route::post('/blood/requests', [RequirerController::class, 'store'])->name('blood.request.store');

Route::get('/blood/requirers', [RequirerController::class, 'requirersIndex'])->name('blood.requirers');
Route::get('/blood/requirers/create', [RequirerController::class, 'requirersCreate'])->name('blood.requirer.create');

Route::get('/blood/contact', [ContactUsQueryController::class, 'create'])->name('blood.contact');
Route::post('/blood/contact', [ContactUsQueryController::class, 'store'])->name('blood.contact.store');
Route::get('/blood/contact-queries', [ContactUsQueryController::class, 'index'])->name('blood.contact-queries');

Route::get('/blood/pages', [BloodPageController::class, 'index'])->name('blood.pages');
Route::get('/blood/pages/create', [BloodPageController::class, 'create'])->name('blood.page.create');
Route::post('/blood/pages', [BloodPageController::class, 'store'])->name('blood.page.store');

Route::get('/blood/contact-info', [ContactInfoController::class, 'index'])->name('blood.contact-info.index');
Route::get('/blood/contact-info/create', [ContactInfoController::class, 'create'])->name('blood.contact-info.create');
Route::post('/blood/contact-info', [ContactInfoController::class, 'store'])->name('blood.contact-info.store');

Route::get('/blood/admin', [BloodAdminController::class, 'dashboard'])->name('blood.admin.dashboard');
Route::get('/blood/admin/register', [BloodAdminController::class, 'create'])->name('blood.admin.create');
Route::post('/blood/admin/register', [BloodAdminController::class, 'store'])->name('blood.admin.store');

Route::get('/operator', [OperatorController::class, 'index'])->name('operator.index');
Route::get('/operator/{type}', [OperatorController::class, 'showForm'])->name('operator.show');
Route::post('/operator/{type}', [OperatorController::class, 'calculate'])->name('operator.calculate');
