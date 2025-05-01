<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnivController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\TaskController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/univ', [UnivController::class, 'index']);

Route::prefix('dashboard')->group(function () {
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index'])->name('tasks.index');
        Route::get('/create', [TaskController::class, 'create'])->name('tasks.create');
        Route::post('/store', [TaskController::class, 'store'])->name('tasks.store');
    });
    
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
