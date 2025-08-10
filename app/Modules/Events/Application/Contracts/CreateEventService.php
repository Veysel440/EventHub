<?php

namespace App\Modules\Events\Application\Contracts;

use App\Modules\Events\Domain\Entities\Event;
use App\Shared\DTO\CreateEventDTO;

interface CreateEventService {
    public function handle(CreateEventDTO $dto): Event;
}
