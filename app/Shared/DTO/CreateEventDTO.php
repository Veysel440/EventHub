<?php

namespace App\Shared\DTO;

final class CreateEventDTO {
    public function __construct(
        public int $tenantId,
        public ?int $venueId,
        public string $title,
        public ?string $description,
        public string $startsAt,
        public string $endsAt
    ) {}
}
