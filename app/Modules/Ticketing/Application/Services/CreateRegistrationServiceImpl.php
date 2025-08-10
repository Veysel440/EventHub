<?php

namespace App\Modules\Ticketing\Application\Services;


use App\Modules\Ticketing\Application\Contracts\CreateRegistrationService;
use App\Modules\Ticketing\Domain\Entities\Registration;
use App\Modules\Ticketing\Domain\Entities\TicketType;
use App\Shared\DTO\CreateRegistrationDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class CreateRegistrationServiceImpl implements CreateRegistrationService
{
    public function handle(CreateRegistrationDTO $dto): Registration
    {
        return DB::transaction(function () use ($dto) {
            /** @var TicketType $ticket */
            $ticket = TicketType::lockForUpdate()->findOrFail($dto->ticketTypeId);

            $reserved = $ticket->registrations()
                ->whereIn('status', [Registration::STATUS_PENDING, Registration::STATUS_PAID])
                ->count();

            if ($reserved >= $ticket->stock) {
                throw ValidationException::withMessages(['stock'=>'No stock available for this ticket type.']);
            }

            return Registration::create([
                'tenant_id'      => $dto->tenantId,
                'event_id'       => $dto->eventId,
                'ticket_type_id' => $dto->ticketTypeId,
                'user_id'        => $dto->userId,
                'buyer_email'    => $dto->buyerEmail,
                'status'         => Registration::STATUS_PENDING,
                'qr_code'        => (string) Str::uuid(),
            ]);
        });
    }
}
