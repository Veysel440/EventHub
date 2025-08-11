<?php

namespace App\Modules\Payments\Application\Contracts;


final class PaymentWebhookPayload
{
    public function __construct(
        public string $provider,
        public string $event,
        public string $providerRef,
        public int    $registrationId,
        public string $amount,
        public string $currency,
        public ?int   $tenantId,
        public array  $raw
    ) {}
}
