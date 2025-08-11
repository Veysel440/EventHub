<?php

namespace App\Modules\Payments\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payments\Application\Services\CreatePaymentIntentService;
use App\Modules\Payments\Application\Contracts\CreatePaymentIntentDTO;
use App\Shared\Support\ApiResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function createIntent(Request $r, CreatePaymentIntentService $svc)
    {
        $r->validate([
            'registration_id'=>['required','integer','exists:registrations,id'],
            'provider'=>['required','in:stripe,iyzico'],
            'success_url'=>['required','url'],
            'cancel_url'=>['required','url'],
        ]);

        $dto = new CreatePaymentIntentDTO(
            tenantId: (int) app('tenant_id'),
            registrationId: (int) $r->integer('registration_id'),
            provider: $r->string('provider'),
            successUrl: $r->string('success_url'),
            cancelUrl: $r->string('cancel_url'),
        );

        $res = $svc->handle($dto);

        return response()->json(ApiResponse::ok([
            'provider'      => $res->provider,
            'provider_ref'  => $res->providerRef,
            'client_secret' => $res->clientSecret,
            'redirect_url'  => $res->redirectUrl,
        ]));
    }
}
