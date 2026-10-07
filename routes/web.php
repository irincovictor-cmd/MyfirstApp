<?php

use App\Http\Controllers\BloodAdminController;
use App\Http\Controllers\BloodAuthController;
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

// Portfolio
Route::get('/', fn () => redirect()->route('home'));
Route::get('/home', fn () => view('portfolio', ['section' => 'home']))->name('home');
Route::get('/portfolio', fn () => view('portfolio', ['section' => 'home']))->name('portfolio');
Route::get('/work', fn () => view('portfolio', ['section' => 'work']))->name('work');
Route::get('/about', fn () => view('portfolio', ['section' => 'about']))->name('about');
Route::get('/contact', fn () => view('portfolio', ['section' => 'contact']))->name('contact');

// Student forms
Route::get('/student', [StudentController::class, 'create'])->name('student.create');
Route::post('/student', [StudentController::class, 'store'])->name('student.store');
Route::get('/student-details', [StudentDetailController::class, 'create'])->name('student-details.create');
Route::post('/student-details', [StudentDetailController::class, 'store'])->name('student-details.store');

/*
|--------------------------------------------------------------------------
| BloodLink
|--------------------------------------------------------------------------
*/
Route::get('/blood', [BloodHomeController::class, 'index'])->name('blood.home');

Route::get('/blood/login', [BloodAuthController::class, 'showLogin'])->name('blood.login');
Route::post('/blood/login', [BloodAuthController::class, 'login'])
    ->middleware('throttle:8,1')
    ->name('blood.login.submit');
Route::get('/blood/register', [BloodAuthController::class, 'showRegister'])->name('blood.register');
Route::post('/blood/register', [BloodAuthController::class, 'register'])
    ->middleware('throttle:5,1')
    ->name('blood.register.submit');
Route::post('/blood/logout', [BloodAuthController::class, 'logout'])->name('blood.logout');

Route::get('/blood/setup-admin', [BloodAdminController::class, 'setupForm'])->name('blood.setup');
Route::post('/blood/setup-admin', [BloodAdminController::class, 'store'])
    ->middleware('throttle:5,1')
    ->name('blood.setup.submit');

Route::get('/blood/pages', [BloodPageController::class, 'index'])->name('blood.pages');
Route::get('/blood/pages/create', [BloodPageController::class, 'create'])
    ->middleware('blood.admin')
    ->name('blood.page.create');
Route::post('/blood/pages', [BloodPageController::class, 'store'])
    ->middleware('blood.admin')
    ->name('blood.page.store');
Route::get('/blood/pages/{page}', [BloodPageController::class, 'show'])
    ->whereNumber('page')
    ->name('blood.page.show');

Route::get('/blood/contact', [ContactUsQueryController::class, 'create'])->name('blood.contact');
Route::post('/blood/contact', [ContactUsQueryController::class, 'store'])->name('blood.contact.store');

Route::middleware('blood.user')->group(function () {
    Route::get('/blood/donors/create', [BloodDonorController::class, 'create'])->name('blood.donor.create');
    Route::post('/blood/donors', [BloodDonorController::class, 'store'])->name('blood.donor.store');

    Route::get('/blood/requests/create', [RequirerController::class, 'create'])->name('blood.request.create');
    Route::post('/blood/requests', [RequirerController::class, 'store'])->name('blood.request.store');
});

Route::middleware('blood.admin')->group(function () {
    Route::get('/blood/admin', [BloodAdminController::class, 'dashboard'])->name('blood.admin.dashboard');
    Route::get('/blood/admin/register', [BloodAdminController::class, 'create'])->name('blood.admin.create');
    Route::post('/blood/admin/register', [BloodAdminController::class, 'store'])->name('blood.admin.store');

    // Manage login accounts
    Route::get('/blood/admin/users', [BloodAdminController::class, 'users'])->name('blood.admin.users');
    Route::post('/blood/admin/users/{user}/password', [BloodAdminController::class, 'updatePassword'])
        ->name('blood.admin.user.password');
    Route::post('/blood/admin/users/{user}/role', [BloodAdminController::class, 'updateRole'])
        ->name('blood.admin.user.role');
    Route::delete('/blood/admin/users/{user}', [BloodAdminController::class, 'destroyUser'])
        ->name('blood.admin.user.destroy');

    Route::get('/blood/donors', [BloodDonorController::class, 'index'])->name('blood.donors');
    Route::post('/blood/donors/{donor}/status', [BloodDonorController::class, 'updateStatus'])
        ->name('blood.donor.status');
    Route::delete('/blood/donors/{donor}', [BloodDonorController::class, 'destroy'])
        ->name('blood.donor.destroy');

    Route::get('/blood/requests', [RequirerController::class, 'index'])->name('blood.requests');
    Route::post('/blood/requests/{requirer}/status', [RequirerController::class, 'updateStatus'])
        ->name('blood.request.status');
    Route::delete('/blood/requests/{requirer}', [RequirerController::class, 'destroy'])
        ->name('blood.request.destroy');

    Route::get('/blood/requirers', [RequirerController::class, 'requirersIndex'])->name('blood.requirers');
    Route::get('/blood/requirers/create', [RequirerController::class, 'requirersCreate'])->name('blood.requirer.create');

    Route::get('/blood/contact-queries', [ContactUsQueryController::class, 'index'])->name('blood.contact-queries');

    Route::get('/blood/contact-info', [ContactInfoController::class, 'index'])->name('blood.contact-info.index');
    Route::get('/blood/contact-info/create', [ContactInfoController::class, 'create'])->name('blood.contact-info.create');
    Route::post('/blood/contact-info', [ContactInfoController::class, 'store'])->name('blood.contact-info.store');
});

Route::get('/operator', [OperatorController::class, 'index'])->name('operator.index');
Route::get('/operator/{type}', [OperatorController::class, 'showForm'])->name('operator.show');
Route::post('/operator/{type}', [OperatorController::class, 'calculate'])->name('operator.calculate');
