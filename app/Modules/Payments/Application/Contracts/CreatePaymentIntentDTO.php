<?php

namespace App\Modules\Payments\Application\Contracts;

final class CreatePaymentIntentDTO
{
    public function __construct(
        public int $tenantId,
        public int $registrationId,
        public string $provider,
        public string $successUrl,
        public string $cancelUrl
    ) {}
}
