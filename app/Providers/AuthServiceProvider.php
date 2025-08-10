<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Modules\Events\Domain\Entities\Event;
use App\Modules\Ticketing\Domain\Entities\TicketType;
use App\Modules\Ticketing\Domain\Entities\Registration;
use App\Policies\EventPolicy;
use App\Policies\TicketTypePolicy;
use App\Policies\RegistrationPolicy;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Event::class => EventPolicy::class,
        TicketType::class => TicketTypePolicy::class,
        Registration::class => RegistrationPolicy::class,
    ];
    public function boot(): void { $this->registerPolicies(); }
}
