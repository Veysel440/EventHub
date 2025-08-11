<?php

namespace App\Modules\Payments\Application\Contracts;

final class PaymentIntentResponse
{
    public function __construct(
        public string $provider,
        public string $providerRef,
        public ?string $clientSecret = null,
        public ?string $redirectUrl = null,
        public array $raw = []
    ) {}
}
