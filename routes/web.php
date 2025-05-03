<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnivController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\DraftController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\TicketsController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/univ', [UnivController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::prefix('dashboard')->group(function () {
        Route::controller(TicketsController::class)
            ->prefix('tickets')
            ->name('tickets.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::get('/show', 'show')->name('show');
                // Route::get('/{ticket}', 'show')->name('show');
                Route::get('/{ticket}/edit', 'edit')->name('edit');
                Route::put('/{ticket}', 'update')->name('update');
                Route::delete('/{ticket}', 'destroy')->name('destroy');
                Route::get('/draft', 'draft')->name('draft');
            });

        Route::controller(InvoiceController::class)
            ->prefix('invoices')
            ->name('invoices.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/report', 'financialReport')->name('report');
                Route::get('/create', 'create')->name('create');
            });
    });
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
