<?php

namespace App\Modules\Ticketing\Application\Services;

use App\Modules\Ticketing\Application\Contracts\CreateTicketTypeService;
use App\Modules\Ticketing\Domain\Entities\TicketType;
use App\Shared\DTO\CreateTicketTypeDTO;

class CreateTicketTypeServiceImpl implements CreateTicketTypeService
{
    public function handle(CreateTicketTypeDTO $dto): TicketType
    {
        if ($dto->stock < 0) {
            throw new \InvalidArgumentException('Stock must be >= 0');
        }
        return TicketType::create([
            'tenant_id' => $dto->tenantId,
            'event_id'  => $dto->eventId,
            'name'      => $dto->name,
            'stock'     => $dto->stock,
            'price'     => $dto->price,
            'currency'  => $dto->currency,
        ]);
    }
}
