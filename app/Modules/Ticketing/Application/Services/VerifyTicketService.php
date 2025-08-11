<?php

namespace App\Modules\Ticketing\Application\Services;

use App\Modules\Ticketing\Domain\Entities\Registration;
use App\Modules\Events\Domain\Entities\Event;
use Illuminate\Validation\ValidationException;

class VerifyTicketService
{
    public function handle(string $qr): Registration
    {
        $reg = Registration::with(['event','ticketType'])->where('qr_code',$qr)->first();
        if (!$reg) throw ValidationException::withMessages(['qr_code'=>'not_found']);

        /** @var Event $event */
        $event = $reg->event;
        if (!$event || $event->status !== Event::STATUS_PUBLISHED) {
            throw ValidationException::withMessages(['event'=>'not_published']);
        }
        if ($reg->status !== Registration::STATUS_PAID) {
            throw ValidationException::withMessages(['status'=>'not_paid']);
        }
        return $reg;
    }
}
