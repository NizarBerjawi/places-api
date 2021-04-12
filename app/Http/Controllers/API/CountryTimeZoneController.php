<?php

namespace App\Http\Controllers\API;

use App\Filters\TimeZoneFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\TimeZoneResource;
use Illuminate\Support\Arr;

class CountryTimeZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\TimeZoneFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(TimeZoneFilter $filter, string $code)
    {
        $timeZones = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getPaginator();
        
        return TimeZoneResource::collection($timeZones);
    }
}
