<?php

namespace App\Modules\Events\Application\Services;

use App\Modules\Events\Application\Contracts\PublishEventService;
use App\Modules\Events\Domain\Entities\Event;
use Illuminate\Validation\ValidationException;

class PublishEventServiceImpl implements PublishEventService
{
    public function handle(Event $event): Event
    {
        if ($event->status !== Event::STATUS_DRAFT) {
            throw ValidationException::withMessages(['status'=>'Only draft events can be published.']);
        }
        $event->update(['status'=>Event::STATUS_PUBLISHED]);
        return $event->refresh();
    }
}
