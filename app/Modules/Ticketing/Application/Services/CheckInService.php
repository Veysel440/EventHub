<?php

namespace App\Modules\Ticketing\Application\Services;

use App\Modules\Ticketing\Domain\Entities\Registration;
use App\Modules\Ticketing\Domain\Entities\CheckInLog;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class CheckInService
{
    public function __construct(private VerifyTicketService $verify) {}

    public function handle(string $qr): Registration
    {
        return DB::transaction(function () use ($qr) {
            $reg = $this->verify->handle($qr);

            if ($reg->status === Registration::STATUS_CHECKED_IN) {
                throw ValidationException::withMessages(['status'=>'already_checked_in']);
            }

            $reg->status = Registration::STATUS_CHECKED_IN;
            $reg->save();

            CheckInLog::create([
                'tenant_id'       => (int) app('tenant_id'),
                'registration_id' => $reg->id,
                'user_id'         => auth()->id(),
                'ip'              => request()->ip(),
                'user_agent'      => (string) request()->header('User-Agent'),
                'device'          => request()->header('X-Device') ?? null,
                'checked_in_at'   => now(),
            ]);

            return $reg->refresh()->load(['event','ticketType']);
        });
    }
}
