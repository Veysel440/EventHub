<?php

namespace App\Modules\Ticketing\Application\Contracts;

use App\Modules\Ticketing\Domain\Entities\TicketType;
use App\Shared\DTO\CreateTicketTypeDTO;

interface CreateTicketTypeService {
    public function handle(CreateTicketTypeDTO $dto): TicketType;
}
