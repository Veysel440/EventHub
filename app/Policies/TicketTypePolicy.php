<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Ticketing\Domain\Entities\TicketType;

class TicketTypePolicy
{
    public function create(User $user): bool { return $user->can('tickets.manage'); }
    public function update(User $user, TicketType $m): bool { return $user->can('tickets.manage'); }
    public function delete(User $user, TicketType $m): bool { return $user->can('tickets.manage'); }
}
