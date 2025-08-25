<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\User\ChatController;

//Route::prefix('api')->group(function () {
    Route::get('/ticket/{ticket}/conversation', [ChatController::class, 'getTicketConversation']);
    Route::get('/ticket/{ticket}/messages', [ChatController::class, 'getTicketMessages']);
    Route::post('/ticket/{ticket}/message', [ChatController::class, 'sendTicketMessage']);
    Route::post('/ticket/{ticket}/read', [ChatController::class, 'markTicketAsRead']);
    Route::post('/ticket/{ticket}/typing', [ChatController::class, 'sendTypingIndicator']);
    // ... other API routes
//});


// Route::middleware(['auth'])->group(function () {
//     Route::get('/conversations', [ChatController::class, 'getConversations']);
//     Route::post('/conversations', [ChatController::class, 'createConversation']);
//     Route::get('/conversations/{conversation}/messages', [ChatController::class, 'getMessages']);
//     Route::post('/conversations/{conversation}/read', [ChatController::class, 'markAsRead']);
//     Route::post('/messages', [ChatController::class, 'sendMessage']);
//     Route::post('/typing', [ChatController::class, 'sendTypingIndicator']);
//     Route::get('/users/available', [ChatController::class, 'getAvailableUsers']);
// });