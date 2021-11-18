<?php

require_once __DIR__ . '/../vendor/autoload.php';

(new Laravel\Lumen\Bootstrap\LoadEnvironmentVariables(
    dirname(__DIR__)
))->bootstrap();

date_default_timezone_set(env('APP_TIMEZONE', 'UTC'));

/*
|--------------------------------------------------------------------------
| Create The Application
|--------------------------------------------------------------------------
|
| Here we will load the environment and create the application instance
| that serves as the central piece of this framework. We'll use this
| application as an "IoC" container and router for this framework.
|
*/

$app = new Laravel\Lumen\Application(
    dirname(__DIR__)
);

$app->withEloquent();

/*
|--------------------------------------------------------------------------
| Register Container Bindings
|--------------------------------------------------------------------------
|
| Now we will register a few bindings in the service container. We will
| register the exception handler and the console kernel. You may add
| your own bindings here if you like or you can make another file.
|
*/
if ($app->environment() === 'local' && config('app.debug')) {
    $app->register(Laravel\Tinker\TinkerServiceProvider::class);
}

$app->singleton(
    Illuminate\Contracts\Debug\ExceptionHandler::class,
    App\Exceptions\Handler::class
);

$app->singleton(
    Illuminate\Contracts\Console\Kernel::class,
    App\Console\Kernel::class
);

/*
|--------------------------------------------------------------------------
| Register Config Files
|--------------------------------------------------------------------------
|
| Now we will register the "app" configuration file. If the file exists in
| your configuration directory it will be loaded; otherwise, we'll load
| the default version. You may register other files below as needed.
|
*/
$app->configure('api');
$app->configure('mail');
$app->configure('logging');
$app->configure('geonames');
$app->configure('responsecache');
$app->configure('http-logger');
$app->configure('json-api-paginate');

$app->alias('mailer', Illuminate\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\Mailer::class);
$app->alias('mailer', Illuminate\Contracts\Mail\MailQueue::class);

/*
|--------------------------------------------------------------------------
| Register Middleware
|--------------------------------------------------------------------------
|
| Next, we will register the middleware with the application. These can
| be global middleware that run before and after each request into a
| route or middleware that'll be assigned to some specific routes.
|
*/

$app->middleware([
    \Bepsvpt\SecureHeaders\SecureHeadersMiddleware::class,
]);

$app->routeMiddleware([
    'api-version' => App\Http\Middleware\ApiVersion::class,
    'http-logger' => Spatie\HttpLogger\Middlewares\HttpLogger::class,
    'throttle' => App\Http\Middleware\RateLimits::class,
    'cache' => Spatie\ResponseCache\Middlewares\CacheResponse::class
]);

/*
|--------------------------------------------------------------------------
| Register Service Providers
|--------------------------------------------------------------------------
|
| Here we will register all of the application's service providers which
| are used to bind services into the container. Service providers are
| totally optional, so you are not required to uncomment this line.
|
*/
$app->register(\Spatie\HttpLogger\HttpLoggerServiceProvider::class);
$app->register(\Spatie\QueryBuilder\QueryBuilderServiceProvider::class);
$app->register(\Spatie\JsonApiPaginate\JsonApiPaginateServiceProvider::class);
$app->register(\Spatie\ResponseCache\ResponseCacheServiceProvider::class);
$app->register(\Illuminate\Mail\MailServiceProvider::class);
$app->register(\Bepsvpt\SecureHeaders\SecureHeadersServiceProvider::class);

/*
|--------------------------------------------------------------------------
| Load The Application Routes
|--------------------------------------------------------------------------
|
| Next we will include the routes file so that they can all be added to
| the application. This will provide all of the URLs the application
| can respond to, as well as the controllers that may handle them.
|
*/

$app->router->group([
    'middleware' => ['http-logger', 'throttle:100,1', 'cache'],
    'namespace'  => 'App\Http\Controllers',
], function ($router) {
    require __DIR__ . '/../routes/web.php';
});

$app->router->group([
    'middleware' => ['http-logger', 'throttle:100,1', 'cache', 'api-version:v1'],
    'namespace'  => 'App\Http\Controllers\Api\V1',
    'prefix'     => 'api/v1'
], function ($router) {
    require __DIR__ . '/../routes/api.v1.php';
});

return $app;
