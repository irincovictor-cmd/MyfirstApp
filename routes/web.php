<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\BloodAdminController;
use App\Http\Controllers\BloodDonorController;
use App\Http\Controllers\BloodPageController;
use App\Http\Controllers\ContactInfoController;
use App\Http\Controllers\ContactUsQueryController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\RequirerController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\StudentDetailController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Portfolio pages
Route::get('/', function () {
    return redirect()->route('home');
});

Route::get('/home', function () {
    return view('portfolio', ['section' => 'home']);
})->name('home');

Route::get('/work', function () {
    return view('portfolio', ['section' => 'work']);
})->name('work');

Route::get('/about', function () {
    return view('portfolio', ['section' => 'about']);
})->name('about');

Route::get('/contact', function () {
    return view('portfolio', ['section' => 'contact']);
})->name('contact');

// ------------------------------------------------------------
// Site admin panel (students list — password protected)
// ------------------------------------------------------------
Route::get('/admin/login', [AdminController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login'])->name('admin.login.submit');
Route::post('/admin/logout', [AdminController::class, 'logout'])->name('admin.logout');

Route::middleware('admin')->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::delete('/admin/students/{student}', [AdminController::class, 'destroy'])->name('admin.students.destroy');
});

// ------------------------------------------------------------
// Student (name, course, age)
// ------------------------------------------------------------
Route::get('/student', [StudentController::class, 'create'])->name('student.create');
Route::post('/student', [StudentController::class, 'store'])->name('student.store');

// ------------------------------------------------------------
// Student details (address, contact) linked to a student
// ------------------------------------------------------------
Route::get('/student-details', [StudentDetailController::class, 'create'])->name('student-details.create');
Route::post('/student-details', [StudentDetailController::class, 'store'])->name('student-details.store');

// ------------------------------------------------------------
// Blood Donation System (ERD) — create forms tomorrow under resources/views/blood/
// ------------------------------------------------------------
Route::get('/blood/admin', [BloodAdminController::class, 'create'])->name('blood.admin.create');
Route::post('/blood/admin', [BloodAdminController::class, 'store'])->name('blood.admin.store');

Route::get('/blood/donor', [BloodDonorController::class, 'create'])->name('blood.donor.create');
Route::post('/blood/donor', [BloodDonorController::class, 'store'])->name('blood.donor.store');

Route::get('/blood/requirer', [RequirerController::class, 'create'])->name('blood.requirer.create');
Route::post('/blood/requirer', [RequirerController::class, 'store'])->name('blood.requirer.store');

Route::get('/blood/contact-query', [ContactUsQueryController::class, 'create'])->name('blood.contact-query.create');
Route::post('/blood/contact-query', [ContactUsQueryController::class, 'store'])->name('blood.contact-query.store');

Route::get('/blood/page', [BloodPageController::class, 'create'])->name('blood.page.create');
Route::post('/blood/page', [BloodPageController::class, 'store'])->name('blood.page.store');

Route::get('/blood/contact-info', [ContactInfoController::class, 'create'])->name('blood.contact-info.create');
Route::post('/blood/contact-info', [ContactInfoController::class, 'store'])->name('blood.contact-info.store');

// Calculator (Operator)
Route::get('/operator', [OperatorController::class, 'index'])->name('operator.index');
Route::get('/operator/{type}', [OperatorController::class, 'showForm'])->name('operator.show');
Route::post('/operator/{type}', [OperatorController::class, 'calculate'])->name('operator.calculate');
