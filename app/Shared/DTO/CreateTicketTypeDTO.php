<?php

namespace App\Shared\DTO;

final class CreateTicketTypeDTO {
    public function __construct(
        public int $tenantId,
        public int $eventId,
        public string $name,
        public int $stock,
        public string $price,
        public string $currency='TRY'
    ) {}
}
