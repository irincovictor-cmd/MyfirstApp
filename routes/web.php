<?php
use App\Http\Controllers\StudentController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;


// Redirect root URL to /home
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

// Student Log in form 

Route::get('student',[StudentController::class,'index']);
Route::post('student',[StudentController::class, 'show']);

Route::get('/operator',[OperatorController::class, 'index'])->name('operator.index');

Route::get('/operator/{type}', [OperatorController::class, 'showForm'])->name('operator.show');

Route::post('/operator/{type}', [OperatorController::class, 'calculate'])->name('operator.calculate');


