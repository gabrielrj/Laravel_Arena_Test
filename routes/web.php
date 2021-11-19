<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

//Welcome
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

//Dashboard
Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

//Customer Routes
Route::prefix('/customers')->name('customers.')->middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\CustomerController::class, 'index'])->name('index');
    Route::get('/create', [\App\Http\Controllers\CustomerController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\CustomerController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [\App\Http\Controllers\CustomerController::class, 'edit'])->name('edit');
    Route::put('/{id}', [\App\Http\Controllers\CustomerController::class, 'update'])->name('update');
    Route::put('/change/status/{id}', [\App\Http\Controllers\CustomerController::class, 'changeStatus'])->name('change.status');
    Route::delete('/{id}', [\App\Http\Controllers\CustomerController::class, 'destroy'])->name('delete');
});

//Number Routes
Route::prefix('/numbers')->name('numbers.')->middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\NumberController::class, 'index'])->name('index');
    Route::get('/create/{id}', [\App\Http\Controllers\NumberController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\NumberController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [\App\Http\Controllers\NumberController::class, 'edit'])->name('edit');
    Route::put('/{id}', [\App\Http\Controllers\NumberController::class, 'update'])->name('update');
    Route::delete('/{id}', [\App\Http\Controllers\NumberController::class, 'destroy'])->name('delete');
    Route::put('/change/status/{id}', [\App\Http\Controllers\NumberController::class, 'changeStatus'])->name('change.status');
});

//Number preferences Routes
Route::prefix('/preferences')->name('preferences.')->middleware(['auth'])->group(function () {
    Route::get('/{id}', [\App\Http\Controllers\NumberPreferencesController::class, 'index'])->name('index');
    Route::get('/create/{id}', [\App\Http\Controllers\NumberPreferencesController::class, 'create'])->name('create');
    Route::post('/', [\App\Http\Controllers\NumberPreferencesController::class, 'store'])->name('store');
    Route::get('/{id}/edit', [\App\Http\Controllers\NumberPreferencesController::class, 'edit'])->name('edit');
    Route::put('/{id}', [\App\Http\Controllers\NumberPreferencesController::class, 'update'])->name('update');
    Route::delete('/{id}', [\App\Http\Controllers\NumberPreferencesController::class, 'destroy'])->name('delete');
});

require __DIR__.'/auth.php';
