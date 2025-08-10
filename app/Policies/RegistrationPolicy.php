<?php

namespace App\Policies;

use App\Models\User;
use App\Modules\Ticketing\Domain\Entities\Registration;

class RegistrationPolicy
{
    public function create(?User $user): bool { return true; }
    public function manage(User $user, Registration $m): bool { return $user->can('registrations.manage'); }
}
