<?php

namespace App\Modules\Payments\Application\Contracts;

use Illuminate\Http\Request;

interface PaymentProvider
{
    public function name(): string;

    public function parseWebhook(Request $request): PaymentWebhookPayload;
}
