<?php

namespace App\Shared\DTO;

final class CreateRegistrationDTO {
    public function __construct(
        public int $tenantId,
        public int $eventId,
        public int $ticketTypeId,
        public ?int $userId,
        public string $buyerEmail
    ) {}
}
