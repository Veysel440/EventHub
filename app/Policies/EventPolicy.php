<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Events\Domain\Entities\Event;

class EventPolicy
{
    public function viewAny(User $user): bool   { return $user->can('events.view'); }
    public function view(User $user, Event $m): bool { return $user->can('events.view'); }
    public function create(User $user): bool    { return $user->can('events.create'); }
    public function update(User $user, Event $m): bool{ return $user->can('events.update'); }
    public function delete(User $user, Event $m): bool{ return $user->can('events.delete'); }
    public function publish(User $user, Event $m): bool{ return $user->can('events.publish'); }
}
