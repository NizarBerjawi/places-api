<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CountryResource;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\CountryFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(CountryFilter $filter)
    {
        $countries = $filter->getPaginator();

        return CountryResource::collection($countries);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Filters\CountryFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(CountryFilter $filter, string $code)
    {
        $country = $filter
            ->getBuilder()
            ->where('iso3166_alpha2', $code)
            ->firstOrFail();

        return new CountryResource($country);
    }
}