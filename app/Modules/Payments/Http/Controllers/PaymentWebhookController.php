<?php

namespace App\Modules\Payments\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Payments\Application\PaymentProviderFactory;
use App\Modules\Payments\Application\Services\HandleWebhookService;
use App\Shared\Support\ApiResponse;
use Illuminate\Http\Request;

class PaymentWebhookController extends Controller
{
    public function handle(
        string $provider,
        Request $request,
        PaymentProviderFactory $factory,
        HandleWebhookService $service
    ){

        $adapter = $factory->get($provider);
        $payload = $adapter->parseWebhook($request);
        $payment = $service->handle($payload);

        return response()->json(ApiResponse::ok([
            'payment_id'=>$payment->id,
            'status'=>$payment->status
        ]));
    }
}
