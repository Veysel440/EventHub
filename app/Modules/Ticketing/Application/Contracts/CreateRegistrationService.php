<?php

namespace App\Modules\Ticketing\Application\Contracts;


use App\Modules\Ticketing\Domain\Entities\Registration;
use App\Shared\DTO\CreateRegistrationDTO;

interface CreateRegistrationService {
    public function handle(CreateRegistrationDTO $dto): Registration;
}
