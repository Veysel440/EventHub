<?php

namespace App\Modules\Payments\Application\Services;

use App\Modules\Payments\Application\PaymentCreatorFactory;
use App\Modules\Payments\Application\Contracts\{CreatePaymentIntentDTO,PaymentIntentResponse};
use App\Modules\Ticketing\Domain\Entities\Registration;
use Illuminate\Support\Facades\DB;

class CreatePaymentIntentService
{
    public function __construct(private PaymentCreatorFactory $factory) {}

    public function handle(CreatePaymentIntentDTO $dto): PaymentIntentResponse
    {
        return DB::transaction(function () use ($dto) {
            $reg = Registration::with('ticketType')->findOrFail($dto->registrationId);
            app()->instance('tenant_id', $dto->tenantId);

            $amount = $reg->ticketType?->price ?? '0.00';

            $creator = $this->factory->get($dto->provider);
            $res = $creator->createIntent($dto);

            $reg->payments()->create([
                'tenant_id'      => $dto->tenantId,
                'amount'         => $amount,
                'currency'       => $reg->ticketType?->currency ?? 'TRY',
                'provider'       => $res->provider,
                'provider_ref'   => $res->providerRef,
                'status'         => \App\Modules\Payments\Domain\Entities\Payment::STATUS_INITIATED,
                'meta'           => $res->raw,
            ]);

            return $res;
        });
    }
}
