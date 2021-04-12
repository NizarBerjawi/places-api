<?php

namespace App\Http\Controllers\API;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use Illuminate\Support\Arr;

class ContinentCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\CountryFilter  $filter
     * @param string $code
     * @return \Illuminate\Http\Response
     */
    public function index(CountryFilter $filter, string $code)
    {
        $countries = $filter
            ->applyScope('byContinent', Arr::wrap($code))
            ->getPaginator();

        return CountryResource::collection($countries);
    }
}
