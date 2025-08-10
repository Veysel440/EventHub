<?php

namespace App\Modules\Ticketing\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Ticketing\Application\Contracts\CreateTicketTypeService;
use App\Modules\Ticketing\Http\Requests\CreateTicketTypeRequest;
use App\Modules\Ticketing\Http\Resources\TicketTypeResource;

class TicketTypeController extends Controller
{
    public function store(CreateTicketTypeRequest $request, CreateTicketTypeService $service): TicketTypeResource
    {
        $ticket = $service->handle(new \App\Shared\DTO\CreateTicketTypeDTO(
            tenantId: $request->tenantId(),
            eventId: (int) $request->validated('event_id'),
            name: $request->validated('name'),
            stock: (int) $request->validated('stock'),
            price: (string) $request->validated('price'),
            currency: $request->validated('currency') ?? 'TRY',
        ));
        return new TicketTypeResource($ticket);
    }
}
