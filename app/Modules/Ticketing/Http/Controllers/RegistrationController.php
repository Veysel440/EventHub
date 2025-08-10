<?php

namespace App\Modules\Ticketing\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Ticketing\Application\Contracts\CreateRegistrationService;
use App\Modules\Ticketing\Http\Requests\CreateRegistrationRequest;
use App\Modules\Ticketing\Http\Resources\RegistrationResource;

class RegistrationController extends Controller
{
    public function store(CreateRegistrationRequest $request, CreateRegistrationService $service): RegistrationResource
    {
        $reg = $service->handle(new \App\Shared\DTO\CreateRegistrationDTO(
            tenantId: $request->tenantId(),
            eventId: (int) $request->validated('event_id'),
            ticketTypeId: (int) $request->validated('ticket_type_id'),
            userId: $request->validated('user_id'),
            buyerEmail: $request->validated('buyer_email'),
        ));
        return new RegistrationResource($reg);
    }
}
