<?php

namespace App\Modules\Payments\Application\Services;

use App\Modules\Payments\Application\Contracts\PaymentWebhookPayload;
use App\Modules\Payments\Domain\Entities\Payment;
use App\Modules\Ticketing\Domain\Entities\Registration;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class HandleWebhookService
{
    public function handle(PaymentWebhookPayload $w): Payment
    {
        return DB::transaction(function () use ($w) {
            /** @var Registration $reg */
            $reg = Registration::lockForUpdate()->findOrFail($w->registrationId);


            if ($w->tenantId) { app()->instance('tenant_id', $w->tenantId); }
            else { app()->instance('tenant_id', (int)$reg->tenant_id); }

            $payment = Payment::where('registration_id', $reg->id)
                ->where('provider', $w->provider)
                ->where('provider_ref', $w->providerRef)
                ->first();

            if (!$payment) {
                $payment = Payment::create([
                    'tenant_id'      => (int) app('tenant_id'),
                    'registration_id'=> $reg->id,
                    'amount'         => $w->amount,
                    'currency'       => $w->currency,
                    'provider'       => $w->provider,
                    'provider_ref'   => $w->providerRef,
                    'status'         => Payment::STATUS_INITIATED,
                    'meta'           => $w->raw,
                ]);
            } else {
                $meta = (array)($payment->meta ?? []);
                $payment->meta = array_merge($meta, $w->raw);
            }


            $statusMap = [
                'payment_succeeded' => [Payment::STATUS_SUCCEEDED, Registration::STATUS_PAID],
                'payment_failed'    => [Payment::STATUS_FAILED,    Registration::STATUS_PENDING],
                'payment_refunded'  => [Payment::STATUS_REFUNDED,  Registration::STATUS_CANCELLED],
            ];
            if (!isset($statusMap[$w->event])) {
                throw ValidationException::withMessages(['event'=>'unsupported_event']);
            }

            [$pStatus, $rStatus] = $statusMap[$w->event];
            $payment->status = $pStatus;
            $payment->save();


            $reg->status = $rStatus;
            $reg->save();

            return $payment->refresh();
        });
    }
}
