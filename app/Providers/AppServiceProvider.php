<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

// Payments factories & adapters
use App\Modules\Payments\Application\PaymentProviderFactory;
use App\Modules\Payments\Application\PaymentCreatorFactory;
use App\Modules\Payments\Infrastructure\StripeAdapter;
use App\Modules\Payments\Infrastructure\IyzicoAdapter;

// Events
use App\Modules\Events\Application\Contracts\CreateEventService as CreateEventServiceContract;
use App\Modules\Events\Application\Contracts\PublishEventService as PublishEventServiceContract;
use App\Modules\Events\Application\Services\CreateEventServiceImpl;
use App\Modules\Events\Application\Services\PublishEventServiceImpl;

// Ticketing
use App\Modules\Ticketing\Application\Contracts\CreateTicketTypeService as CreateTicketTypeServiceContract;
use App\Modules\Ticketing\Application\Contracts\CreateRegistrationService as CreateRegistrationServiceContract;
use App\Modules\Ticketing\Application\Services\CreateTicketTypeServiceImpl;
use App\Modules\Ticketing\Application\Services\CreateRegistrationServiceImpl;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Application service bindings
        $this->app->bind(CreateEventServiceContract::class, CreateEventServiceImpl::class);
        $this->app->bind(PublishEventServiceContract::class, PublishEventServiceImpl::class);
        $this->app->bind(CreateTicketTypeServiceContract::class, CreateTicketTypeServiceImpl::class);
        $this->app->bind(CreateRegistrationServiceContract::class, CreateRegistrationServiceImpl::class);

        // Payments factories
        $this->app->singleton(PaymentProviderFactory::class, function ($app) {
            return new PaymentProviderFactory([
                $app->make(StripeAdapter::class),
                $app->make(IyzicoAdapter::class),
            ]);
        });

        $this->app->singleton(PaymentCreatorFactory::class, function ($app) {
            return new PaymentCreatorFactory([
                $app->make(StripeAdapter::class),
                $app->make(IyzicoAdapter::class),
            ]);
        });
    }

    public function boot(): void
    {
        //
    }
}
