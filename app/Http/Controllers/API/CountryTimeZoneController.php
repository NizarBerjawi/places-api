<?php

namespace App\Http\Controllers\API;

use App\Filters\TimeZoneFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\TimeZoneResource;
use App\Models\Country;
use Illuminate\Support\Arr;

class CountryTimeZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\TimeZoneFilter  $filter
     * @param  \App\Models\Country      $country
     * @return \Illuminate\Http\Response
     */
    public function index(TimeZoneFilter $filter, Country $country)
    {
        $timeZones = $filter
            ->applyScope('byCountry', Arr::wrap($country->iso3166_alpha2))
            ->getPaginator();
        
        return TimeZoneResource::collection($timeZones);
    }
}
