<?php

use Botble\AiChatbot\Http\Controllers\AiChatbotController;
use Botble\AiChatbot\Http\Controllers\ChatApiController;
use Botble\AiChatbot\Http\Controllers\LiveChatController;
use Botble\Base\Facades\AdminHelper;
use Illuminate\Support\Facades\Route;

// Admin routes
AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'ai-chatbot', 'as' => 'ai-chatbot.'], function () {
        Route::get('/', [AiChatbotController::class, 'index'])->name('index');
        Route::get('/knowledge', [AiChatbotController::class, 'knowledge'])->name('knowledge');
        Route::post('/knowledge', [AiChatbotController::class, 'storeKnowledge'])->name('knowledge.store');
        Route::put('/knowledge/{id}', [AiChatbotController::class, 'updateKnowledge'])->name('knowledge.update');
        Route::delete('/knowledge/{id}', [AiChatbotController::class, 'deleteKnowledge'])->name('knowledge.delete');
        Route::get('/conversations', [AiChatbotController::class, 'conversations'])->name('conversations');
        Route::get('/settings', [AiChatbotController::class, 'settings'])->name('settings');
        Route::post('/settings', [AiChatbotController::class, 'saveSettings'])->name('settings.save');
        Route::post('/fetch-models', [AiChatbotController::class, 'fetchModels'])->name('fetch-models');
        Route::post('/sync', [AiChatbotController::class, 'syncKnowledge'])->name('sync');

        // Live Chat routes
        Route::get('/live-chat', [AiChatbotController::class, 'liveChat'])->name('live-chat');
    });
});

// Public API routes for chatbot widget
Route::group(['prefix' => 'api/chatbot', 'as' => 'chatbot.api.'], function () {
    Route::post('/chat', [ChatApiController::class, 'chat'])->name('chat');
    Route::get('/status', [ChatApiController::class, 'status'])->name('status');
    Route::get('/poll/{session_id}', [ChatApiController::class, 'poll'])->name('poll');
    Route::post('/track-action', [ChatApiController::class, 'trackAction'])->name('track-action');

    // Chatbot booking routes
    Route::get('/courts', [ChatApiController::class, 'getCourts'])->name('courts');
    Route::get('/available-slots', [ChatApiController::class, 'getAvailableSlots'])->name('available-slots');
    Route::post('/create-booking', [ChatApiController::class, 'createBooking'])->name('create-booking');
});

// Live Chat API for staff (admin authenticated)
AdminHelper::registerRoutes(function () {
    Route::group(['prefix' => 'api/live-chat', 'as' => 'live-chat.api.'], function () {
        Route::get('/sessions', [LiveChatController::class, 'getActiveSessions'])->name('sessions');
        Route::get('/messages/{session_id}', [LiveChatController::class, 'getSessionMessages'])->name('messages');
        Route::post('/send', [LiveChatController::class, 'sendMessage'])->name('send');
        Route::post('/toggle', [LiveChatController::class, 'toggleLive'])->name('toggle');
    });
});
