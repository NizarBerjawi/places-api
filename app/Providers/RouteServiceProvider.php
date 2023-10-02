<?php

namespace App\Providers;

use App\Models\Sanctum\PersonalAccessToken;
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
            Route::middleware(($isProduction ? ['auth:sanctum', 'api'] : []) + ['api.version:v1'])
                ->prefix('api/v1')
                ->group(base_path('routes/api.v1.php'));

            Route::middleware(['web', 'cache.headers:no_store'])
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
            $token = PersonalAccessToken::query()
                ->byToken($request->bearerToken())
                ->with('tokenable.subscriptions')
                ->first();

            $rateLimit = $token
                ->tokenable
                ->subscriptions
                ->first()
                ->requests_per_minute;

            return Limit::perMinute($rateLimit)
                ->by($token->uuid ?: $request->ip());
        });
    }
}
