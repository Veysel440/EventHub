<?php

namespace App\Modules\Payments\Application\Contracts;

interface PaymentCreator
{
    public function name(): string;

    public function createIntent(CreatePaymentIntentDTO $dto): PaymentIntentResponse;
}
