<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = 'user/tokens';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $isProduction = app()->isProduction();

        if ($isProduction) {
            $this->configureRateLimiting();
        }

        $this->routes(function () use ($isProduction) {
            Route::middleware(($isProduction ? ['auth:sanctum', 'api'] : []) + ['api-version:v1'])
                ->prefix('api/v1')
                ->group(base_path('routes/api.v1.php'));

            Route::middleware('web')
                ->group(base_path('routes/web.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(25)->by($request->bearerToken() ?: $request->ip());
        });
    }
}
