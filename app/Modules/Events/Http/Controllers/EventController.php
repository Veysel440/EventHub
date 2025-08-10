<?php

namespace App\Modules\Events\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Events\Application\Contracts\CreateEventService;
use App\Modules\Events\Application\Contracts\PublishEventService;
use App\Modules\Events\Domain\Entities\Event;
use App\Modules\Events\Http\Requests\CreateEventRequest;
use App\Modules\Events\Http\Resources\EventResource;
use Illuminate\Http\Resources\Json\ResourceCollection;

class EventController extends Controller
{
    public function index(): ResourceCollection
    {
        $events = Event::query()->latest('starts_at')->paginate(20);
        return EventResource::collection($events);
    }

    public function store(CreateEventRequest $request, CreateEventService $service): EventResource
    {
        $event = $service->handle(new \App\Shared\DTO\CreateEventDTO(
            tenantId: $request->tenantId(),
            venueId: $request->validated('venue_id'),
            title: $request->validated('title'),
            description: $request->validated('description'),
            startsAt: $request->validated('starts_at'),
            endsAt: $request->validated('ends_at'),
        ));
        return new EventResource($event);
    }

    public function publish(Event $event, PublishEventService $service): EventResource
    {
        $this->authorize('events.publish');
        return new EventResource($service->handle($event));
    }
}
