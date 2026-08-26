<?php

use App\Http\Controllers\OperatorController;
use App\Http\Controllers\StudentController;
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
// Student form
// GET  /student  → show the form
// POST /student  → handle submit and show result
// ------------------------------------------------------------
Route::get('/student', [StudentController::class, 'index'])->name('student.index');
Route::post('/student', [StudentController::class, 'show'])->name('student.show');

// Calculator (Operator)
Route::get('/operator', [OperatorController::class, 'index'])->name('operator.index');
Route::get('/operator/{type}', [OperatorController::class, 'showForm'])->name('operator.show');
Route::post('/operator/{type}', [OperatorController::class, 'calculate'])->name('operator.calculate');
