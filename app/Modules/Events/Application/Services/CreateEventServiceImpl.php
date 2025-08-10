<?php

namespace App\Modules\Events\Application\Services;

use App\Modules\Events\Application\Contracts\CreateEventService;
use App\Modules\Events\Domain\Entities\Event;
use App\Shared\DTO\CreateEventDTO;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CreateEventServiceImpl implements CreateEventService
{
    public function handle(CreateEventDTO $dto): Event
    {
        return DB::transaction(function () use ($dto) {
            return Event::create([
                'tenant_id'   => $dto->tenantId,
                'venue_id'    => $dto->venueId,
                'public_id'   => (string) Str::uuid(),
                'title'       => $dto->title,
                'description' => $dto->description,
                'starts_at'   => $dto->startsAt,
                'ends_at'     => $dto->endsAt,
                'status'      => Event::STATUS_DRAFT,
            ]);
        });
    }
}
