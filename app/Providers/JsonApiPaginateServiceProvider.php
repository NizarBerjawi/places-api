<?php

namespace App\Providers;

use Spatie\JsonApiPaginate\JsonApiPaginateServiceProvider as SpatieJsonApiPaginate;

class JsonApiPaginateServiceProvider extends SpatieJsonApiPaginate
{
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/json-api-paginate.php' => __DIR__.'/../../config/json-api-paginate.php',
            ], 'config');
        }

        $this->registerMacro();
    }
}
