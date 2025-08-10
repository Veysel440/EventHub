<?php

use App\Modules\Events\Http\Controllers\EventController;
use App\Modules\Ticketing\Http\Controllers\TicketTypeController;
use App\Modules\Ticketing\Http\Controllers\RegistrationController;

Route::middleware(['auth:sanctum','tenant'])->prefix('v1')->group(function () {
    Route::get('/events', [EventController::class,'index'])->middleware('permission:events.view');
    Route::post('/events', [EventController::class,'store'])->middleware('permission:events.create');
    Route::post('/events/{event}/publish', [EventController::class,'publish'])->middleware('permission:events.publish');

    Route::post('/ticket-types', [TicketTypeController::class,'store'])->middleware('permission:tickets.manage');

    Route::post('/registrations', [RegistrationController::class,'store']);
});
