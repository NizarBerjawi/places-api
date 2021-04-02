<?php

namespace App\Http\Controllers\API;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Country;

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
     * @param  \App\Models\Country $country
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return new CountryResource($country);
    }
}