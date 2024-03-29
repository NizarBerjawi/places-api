<?php

namespace App\Cache;

use Illuminate\Http\Request;
use Spatie\ResponseCache\CacheProfiles\CacheAllSuccessfulGetRequests as CacheProfilesCacheAllSuccessfulGetRequests;

class CacheAllSuccessfulGetRequests extends CacheProfilesCacheAllSuccessfulGetRequests
{
    /**
     * Determine if a request should be caches.
     */
    public function shouldCacheRequest(Request $request): bool
    {
        return $request->isMethod('get') && ! $this->isRunningInConsole();
    }

    /**
     * The suffix to add to the Cache name.
     */
    public function useCacheNameSuffix(Request $request): string
    {
        return '';
    }
}
