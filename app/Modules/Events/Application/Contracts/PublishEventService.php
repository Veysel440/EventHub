<?php

namespace App\Modules\Events\Application\Contracts;

use App\Modules\Events\Domain\Entities\Event;

interface PublishEventService {
    public function handle(Event $event): Event;
}
