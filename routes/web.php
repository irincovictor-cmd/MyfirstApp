<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\OperatorController;
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
// Simple admin panel (list students + details from DB)
// ------------------------------------------------------------
Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');

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

// Calculator (Operator)
Route::get('/operator', [OperatorController::class, 'index'])->name('operator.index');
Route::get('/operator/{type}', [OperatorController::class, 'showForm'])->name('operator.show');
Route::post('/operator/{type}', [OperatorController::class, 'calculate'])->name('operator.calculate');
