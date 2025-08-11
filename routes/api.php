<?php

// Controllers
use App\Modules\Events\Http\Controllers\EventController;
use App\Modules\Ticketing\Http\Controllers\TicketTypeController;
use App\Modules\Ticketing\Http\Controllers\RegistrationController;
use App\Modules\Ticketing\Http\Controllers\CheckInController;
use App\Modules\Payments\Http\Controllers\PaymentController;
use App\Modules\Payments\Http\Controllers\PaymentWebhookController;

/*
|--------------------------------------------------------------------------
| API Routes v1
|--------------------------------------------------------------------------
| Not: "tenant" middleware tüm kiracı izolasyonu için zorunlu.
|      Webhook endpoint'lerinde auth ve tenant yok.
*/

// PROTECTED (auth + tenant)
Route::middleware(['auth:sanctum','tenant'])->prefix('v1')->group(function () {

    // Events
    Route::get('/events', [EventController::class,'index'])
        ->middleware('permission:events.view');
    Route::post('/events', [EventController::class,'store'])
        ->middleware('permission:events.create');
    Route::post('/events/{event}/publish', [EventController::class,'publish'])
        ->middleware('permission:events.publish');

    // Ticket Types
    Route::post('/ticket-types', [TicketTypeController::class,'store'])
        ->middleware('permission:tickets.manage');


    Route::post('/registrations', [RegistrationController::class,'store']);

    // Payments - Intent
    Route::post('/payments/intent', [PaymentController::class,'createIntent'])
        ->middleware('permission:payments.manage');


    Route::post('/checkin', [CheckInController::class,'checkin'])
        ->middleware(['permission:checkin.manage','throttle:checkin']);
});


Route::prefix('v1')->middleware(['tenant'])->group(function () {


    Route::post('/checkin/verify', [CheckInController::class,'verify'])
        ->middleware('throttle:checkin-verify');
});


Route::post('/v1/payments/webhook/{provider}', [PaymentWebhookController::class,'handle'])
    ->whereIn('provider', ['stripe','iyzico']);
