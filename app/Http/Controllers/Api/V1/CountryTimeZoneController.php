<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\TimeZoneFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TimeZoneResource;
use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $timeZones = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getPaginator();

        return TimeZoneResource::collection($timeZones);
    }
}
