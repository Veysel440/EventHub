<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            \App\Modules\Events\Application\Contracts\CreateEventService::class,
            \App\Modules\Events\Application\Services\CreateEventServiceImpl::class
        );
        $this->app->bind(
            \App\Modules\Events\Application\Contracts\PublishEventService::class,
            \App\Modules\Events\Application\Services\PublishEventServiceImpl::class
        );
        $this->app->bind(
            \App\Modules\Ticketing\Application\Contracts\CreateTicketTypeService::class,
            \App\Modules\Ticketing\Application\Services\CreateTicketTypeServiceImpl::class
        );
        $this->app->bind(
            \App\Modules\Ticketing\Application\Contracts\CreateRegistrationService::class,
            \App\Modules\Ticketing\Application\Services\CreateRegistrationServiceImpl::class
        );
    }

    public function boot(): void
    {
        //
    }
}
