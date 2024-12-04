<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubsetController;
use App\Http\Controllers\TestController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


Route::get('/home', [SubsetController::class, 'index'])->name('home')->middleware('auth');
Route::get('/', [SubsetController::class, 'index']);
Route::get('/', [SubsetController::class, 'index'])->middleware('auth')->name('home');

Route::get('/test/start', [TestController::class, 'start'])->name('test.start')->middleware('auth');

Route::get('/test/result', [TestController::class, 'result'])->name('test.result');

// Ruta para manejar el envío de respuestas (procesar las respuestas y mostrar el resultado)
Route::post('/test/submit', [TestController::class, 'submit'])->name('test.submit');

