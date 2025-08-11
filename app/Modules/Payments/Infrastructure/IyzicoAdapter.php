<?php

namespace App\Modules\Payments\Infrastructure;

use App\Modules\Payments\Application\Contracts\PaymentProvider;
use App\Modules\Payments\Application\Contracts\PaymentCreator;
use App\Modules\Payments\Application\Contracts\{PaymentWebhookPayload,CreatePaymentIntentDTO,PaymentIntentResponse};
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
class IyzicoAdapter implements PaymentProvider
{
    public function name(): string { return 'iyzico'; }

    public function parseWebhook(Request $request): PaymentWebhookPayload
    {
        $sig = $request->header('X-Iyzico-Signature');
        $secret = config('payment.iyzico.webhook_secret');
        if (!$sig || !$secret) { throw new BadRequestHttpException('signature_missing'); }

        $calc = hash_hmac('sha256', $request->getContent(), $secret);
        if (!hash_equals($calc, $sig)) { throw new BadRequestHttpException('invalid_signature'); }

        $p = $request->all();
        $status = $p['paymentStatus'] ?? '';
        $event = match (strtolower($status)) {
            'success' => 'payment_succeeded',
            'failure' => 'payment_failed',
            'refunded' => 'payment_refunded',
            default => 'unknown',
        };

        $regId = (int)($p['metadata']['registration_id'] ?? 0);
        $tenantId = isset($p['metadata']['tenant_id']) ? (int)$p['metadata']['tenant_id'] : null;

        return new PaymentWebhookPayload(
            provider: 'iyzico',
            event: $event,
            providerRef: (string)($p['paymentId'] ?? ''),
            registrationId: $regId,
            amount: (string)($p['paidPrice'] ?? '0.00'),
            currency: strtoupper($p['currency'] ?? 'TRY'),
            tenantId: $tenantId,
            raw: $p
        );
    }

    public function createIntent(CreatePaymentIntentDTO $dto): PaymentIntentResponse
    {
        $fakePaymentPageUrl = 'https://sandbox-iyzico.test/pay/'.uniqid();

        return new PaymentIntentResponse(
            provider: 'iyzico',
            providerRef: 'iyz_'.uniqid(),
            redirectUrl: $fakePaymentPageUrl,
            raw: [
                'amount'=> 'to-be-calculated',
                'currency'=> 'TRY',
                'callbackSuccess'=>$dto->successUrl,
                'callbackCancel'=>$dto->cancelUrl,
                'metadata'=> [
                    'registration_id'=>$dto->registrationId,
                    'tenant_id'=>$dto->tenantId
                ],
            ],
        );
    }
}
