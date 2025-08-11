<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;

class RouteServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->configureRateLimiting();
        $this->routes(function () {
            require base_path('routes/api.php');
        });
    }

    protected function configureRateLimiting(): void
    {
        RateLimiter::for('checkin', function (Request $request) {
            $tenant = (string) app('tenant_id', '0');
            $user   = (string) optional($request->user())->id ?: 'guest';
            return Limit::perMinute(60)->by($tenant.'|'.$user);
        });

        RateLimiter::for('checkin-verify', function (Request $request) {
            $tenant = (string) app('tenant_id', '0');
            $ip     = (string) $request->ip();
            return Limit::perMinute(120)->by($tenant.'|'.$ip);
        });
    }
}
