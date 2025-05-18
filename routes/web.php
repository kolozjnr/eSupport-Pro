<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnivController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\DraftController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\TicketsController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\User\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/univ', [UnivController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
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
                Route::get('/view-drafts', 'viewDrafts')->name('view-drafts');
                Route::get('/view-feedback', 'viewFeedback')->name('view-feedback');
            });

        Route::controller(InvoiceController::class)
            ->prefix('invoices')
            ->name('invoices.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/report', 'financialReport')->name('report');
                Route::get('/create', 'create')->name('create');
            });

        Route::controller(UserController::class)
        ->prefix('users')
        ->name('users.')
        ->group(function(){
            Route::get('/create', 'createUser')->name('create');
            Route::get('/manage-roles', 'manageRoles')->name('manage-roles');
            Route::get('/knowledgebase', 'getKnowledgebase')->name('knowledgebase');
        });

        Route::controller(CustomerController::class)
        ->prefix('customers')
        ->name('customers.')
        ->group(function(){
            Route::get('/onboard', 'getOnboarding')->name('onboard');
            Route::get('/manage', 'manageCustomer')->name('manage');
            Route::get('/edit/{id}', 'show')->name('edit');
            Route::get('/pricing', 'pricing')->name('pricing');
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
