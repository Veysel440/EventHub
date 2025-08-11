<?php

namespace App\Policies;


use App\Models\User;

class CheckInPolicy
{
    public function manage(User $user): bool
    { return $user->can('checkin.manage'); }
}
