<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UnivController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\User\TaskController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\User\DraftController;
use App\Http\Controllers\User\ReviewController;
use App\Http\Controllers\User\InvoiceController;
use App\Http\Controllers\User\SupportController;
use App\Http\Controllers\User\TicketsController;
use App\Http\Controllers\User\CustomerController;
use App\Http\Controllers\User\SettingsController;
use App\Http\Controllers\User\DashboardController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\AdministratorController;
use App\Http\Controllers\User\MonnifyPaymentController;
use App\Http\Controllers\User\BusinesDeveloperController;
use App\Http\Controllers\User\SupportPerfomanceController;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('landing.index');
})->name('home');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');


// Route::get('/dashboard', function () {
//     return view('user.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');


Route::get('/univ', [UnivController::class, 'index']);
Route::get('/dashboard/roles', [UnivController::class, 'getUserRole']);
Route::get('/dashboard/email', [UnivController::class, 'testEmail']);
Route::post('/contact-email', [UnivController::class, 'contactEmail'])->name('contact-email');

Route::post('/pay/monnify', [MonnifyPaymentController::class, 'pay'])->name('monnify.pay');
Route::get('/monnify/callback', [MonnifyPaymentController::class, 'callback'])->name('monnify.callback');
Route::post('/monnify/webhook', [MonnifyPaymentController::class, 'webhook']);



Route::middleware('auth')->group(function () {
    Route::get('/test', [DashboardController::class, 'dashboard1'])->name('dashboards');
    
    Route::prefix('/dashboard')->group(function () {
        Route::controller(DashboardController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/support-chart', 'supportChart')->name('supportChart');

                Route::get('/subscription-metrics', 'subscriptionMetrics')->name('subscriptionMetrics');
                
            });
    });
    Route::prefix('/dashboard')->group(function () {
        Route::controller(UnivController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/support', 'fetchSupport')->name('support');
            });
    });
    Route::prefix('/dashboard')->group(function () {
        Route::controller(SupportPerfomanceController::class)
            ->prefix('users')
            ->name('users.')
            ->group(function () {
                Route::get('/support-metrics-pie', 'getSupportPerformanceMetrics')->name('support');
            });
    });
    Route::prefix('dashboard')->group(function () {
        Route::controller(TicketsController::class)
            ->prefix('tickets')
            ->name('tickets.')
            ->group(function () {
                
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/store', 'store')->name('store');
                Route::post('/bulk-upload', 'bulkUpload')->name('bulk-upload');
                Route::get('/template-tickets', 'downloadTemplate')->name('download-template');
                Route::get('/show', 'show')->name('show');
                // Route::get('/{ticket}', 'show')->name('show');
                Route::get('/customer-tickets', 'getCustomerTickets')->name('CustomerTickets');
                Route::get('/quality-control-tickets', 'getQualityControlTickets')->name('QualityControlTickets');
                //Assign Ticket QA
                Route::post('/bulk-assign-ticket', 'assignTicketByQualityControl')->name('bulk-assign-ticket');
                
                Route::get('/{ticket}/edit-ticket', 'editTicket')->name('edit-ticket');
                Route::put('/tickets/{ticket}', 'updateTicket')->name('user.tickets.update');
                Route::get('/view-single-ticket/{ticket}', 'viewSingleTicket')->name('viewSingleTicket');
                Route::delete('/{ticket}', 'destroy')->name('destroy');
                Route::get('/draft', 'draft')->name('draft');
                //Review

                //support ticket
                Route::get('/support-tickets', 'getSupportTicket')->name('support-tickets');
                Route::post('/tickets/update-status/{id}', 'updateSupportTicket')->name('updateSupportTicket');

                Route::get('/template-draft', 'draftTemplate')->name('draft-template');
                Route::get('/view-drafts', 'viewDrafts')->name('view-drafts');
                Route::get('/data-drafts', 'getDraft')->name('data-drafts');
                Route::post('/store-draft', 'storeDraft')->name('storeDraft');
                Route::post('/bulk-draft-upload', 'bulkDraftUpload')->name('bulk-draft-upload');
                // Route::delete('/{draft}', [DraftController::class, 'destroy'])->name('drafts.destroy');
                Route::get('/view-feedback', 'viewFeedback')->name('view-feedback');

                //Ticket onBehalf
                Route::get('/create-onbehalf', 'createTicketonBehalf')->name('create-onbehalf');
                Route::get('/get-tickets-onbehalf', 'getCustomerTicketsOnBehalf')->name('get-tickets-onbehalf');
                Route::get('/view-tickets-onbehalf', 'viewOnbehalfTicket')->name('view-tickets-onbehalf');
                Route::post('/update-onbehalf', 'actionOnTicketByCustomerOnbehalf')->name('update-onbehalf');
            });
            Route::controller(DraftController::class)
            ->prefix('support')
            ->name('support.')
            ->group(function () {
                Route::get('/identity', 'index')->name('index');
            });
            Route::controller(ReviewController::class)
            ->prefix('reviews')
            ->name('reviews.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/create', 'create')->name('create');
                Route::post('/post-review', 'reviewTicket')->name('store');
                Route::get('/{review}', 'show')->name('show');
                Route::get('/{review}/edit', 'edit')->name('edit');
                Route::put('/{review}', 'update')->name('update');
                Route::delete('/{review}', 'destroy')->name('destroy');
            });

            // Administrator settings
            Route::controller(SettingsController::class)
            ->prefix('settings')
            ->name('settings.')
            ->group(function(){
                Route::get('/', 'viewSettings')->name('index');
                Route::post('/post-settings', 'postSettings')->name('store');
            });

        Route::controller(InvoiceController::class)
            ->prefix('invoices')
            ->name('invoices.')
            ->group(function () {
                Route::get('/', 'index')->name('index');
                Route::get('/report', 'financialReport')->name('report');
                Route::get('/create', 'create')->name('create');
                Route::get('/subscriptions', 'getSubscription')->name('subscriptions');
            });

        Route::controller(UserController::class)
        ->prefix('users')
        ->name('users.')
        ->group(function(){
            Route::get('/create', 'createUser')->name('create');
            Route::get('/manage-roles', 'manageRoles')->name('manage-roles');
            Route::get('/knowledgebase', 'getKnowledgebase')->name('knowledgebase');
            Route::post('/post-user', 'postUserCreation')->name('store');
            Route::get('/assign-customer', 'assignCustomer')->name('assign-customer');
            Route::post('/post-assign', 'postAssignCustomer')->name('post-customer');
            Route::get('/manage',  'getAllUsers')->name('get-all-users');
            //Route::post('/{user}/change-role', 'changeRole')->name('change-role');
            Route::post('/update-role', 'updateUserRole')->name('update-role');
            Route::get('/manage-users', 'manageUsers')->name('manage-users');
             Route::post('{user}/status', 'updateStatus')->name('update-status');
            Route::get('{user}/status', 'getUserStatus')->name('get-status');
            Route::post('bulk-status-update', 'bulkUpdateStatus')->name('bulk-status-update');
            Route::get('status-stats', 'getStatusStats')->name('status-stats');

            Route::delete('/{user}', 'destroy');
        });

        Route::controller(AdministratorController::class)
        ->prefix('administrator')
        ->name('admin.')
        ->group(function(){
            Route::get('/admin-stats', 'adminStats')->name('admin-stats');
        });

        Route::controller(BusinesDeveloperController::class)
        ->prefix('busines-developer')
        ->name('busines-developer.')
        ->group(function(){
            Route::get('/', 'bussinesDeveloperDashboard')->name('bussines-developer-dashboard');
            Route::get('/send-emails', 'sendEmails')->name('send-emails');
            Route::get('/my-customers', 'getAllMyCustomers')->name('my-customers');
            Route::post('/send-single', 'sendSingleEmail')->name('send-single-post');
            Route::post('/send-inactive', 'sendInactiveEmail')->name('send-inactive-post');
            Route::post('/send-to-all-customers', 'sendAllCustomerEmail')->name('send-all-customers');
        });

        Route::controller(CustomerController::class)
        ->prefix('customers')
        ->name('customers.')
        ->group(function(){
            Route::get('/onboard', 'getOnboarding')->name('onboard');
            Route::get('/manage', 'manageCustomer')->name('manage');
            Route::get('/edit/{id}', 'show')->name('edit');
            Route::get('/pricing', 'pricing')->name('pricing');
            Route::get('/customer-dashboard', 'customerDashboard');
            Route::put('/update/{id}', 'updateCustomer')->name('update');
            Route::get('/download-onboarmanading-template', 'downloadTemplate')->name('download-onboarding-template');
            Route::post('/bulk-customer-upload', 'bulkUpload')->name('bulk-customer-upload');
            Route::post('/single-customer', 'store')->name('single-customer');
        });

        Route::controller(SupportController::class)
        ->prefix('support')
        ->name('support.')
        ->group(function(){
            Route::get('/manage-identity', 'getSupports')->name('manage-identity');
            Route::get('/get-support-identity/{support_id}', 'getIdentity')->name('get-identity');
            Route::post('/update-identity', 'updateIdentity')->name('update-identity');
        });

        Route::controller(NotificationController::class)
        ->prefix('notifications')
        ->name('notifications.')
        ->group(function(){
            Route::get('/notifications', 'index');
            Route::get('/notifications/{id}', 'show');
            Route::post('/notifications/read/{id}', 'viewNotification');
        });
    });
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
