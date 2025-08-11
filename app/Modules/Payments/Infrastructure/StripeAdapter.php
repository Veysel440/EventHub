<?php

namespace App\Modules\Payments\Infrastructure;

use App\Modules\Payments\Application\Contracts\PaymentProvider;
use App\Modules\Payments\Application\Contracts\PaymentCreator;
use App\Modules\Payments\Application\Contracts\{PaymentWebhookPayload,CreatePaymentIntentDTO,PaymentIntentResponse};
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class StripeAdapter implements PaymentProvider
{
    public function name(): string { return 'stripe'; }

    public function parseWebhook(Request $request): PaymentWebhookPayload
    {
        $sig = $request->header('Stripe-Signature');
        $secret = config('payment.stripe.webhook_secret');
        if (!$sig || !$secret) { throw new BadRequestHttpException('signature_missing'); }

        if (!hash_equals($secret, $sig)) { throw new BadRequestHttpException('invalid_signature'); }

        $payload = $request->all();
        $type = $payload['type'] ?? '';
        $obj  = $payload['data']['object'] ?? [];

        $event = match ($type) {
            'charge.succeeded','payment_intent.succeeded' => 'payment_succeeded',
            'charge.failed','payment_intent.payment_failed' => 'payment_failed',
            'charge.refunded' => 'payment_refunded',
            default => 'unknown',
        };

        $regId = (int)($obj['metadata']['registration_id'] ?? 0);
        $tenantId = isset($obj['metadata']['tenant_id']) ? (int)$obj['metadata']['tenant_id'] : null;

        return new PaymentWebhookPayload(
            provider: 'stripe',
            event: $event,
            providerRef: (string)($obj['id'] ?? ''),
            registrationId: $regId,
            amount: (string)number_format(($obj['amount'] ?? 0)/100, 2, '.', ''),
            currency: strtoupper($obj['currency'] ?? 'TRY'),
            tenantId: $tenantId,
            raw: $payload
        );
    }

    public function createIntent(CreatePaymentIntentDTO $dto): PaymentIntentResponse
    {
        $fakeId = 'pi_' . uniqid();
        $clientSecret = 'cs_' . uniqid();

        return new PaymentIntentResponse(
            provider: 'stripe',
            providerRef: $fakeId,
            clientSecret: $clientSecret,
            raw: [
                'amount' => 'to-be-calculated',
                'currency' => 'TRY',
                'metadata' => [
                    'registration_id' => $dto->registrationId,
                    'tenant_id' => $dto->tenantId
                ],
            ],
        );
    }
}
