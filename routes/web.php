<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SubsetController;
use App\Http\Controllers\TestController;
use App\Http\Controllers\UserController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

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


// Ruta para la página de inicio con la lista de subsets

// Agrupa las rutas del examen que requieren autenticación
Route::middleware(['auth'])->group(function () {
    Route::get('/test/{exam}/question', [TestController::class, 'showQuestion'])->name('test.question');
    Route::post('/test/{exam}/answer', [TestController::class, 'saveAnswer'])->name('test.saveAnswer');
    Route::get('/test/{exam}/results', [TestController::class, 'showResults'])->name('test.results');
   
    Route::get('/home', [SubsetController::class, 'index'])->name('home')->middleware('auth'); 
    Route::post('/test/start', [TestController::class, 'start'])->name('test.start'); 

    Route::get('/users', [UserController::class, 'index'])->name('users.index');
    Route::get('/users/{id}', [UserController::class, 'show'])->name('users.show');
    
});


