<?php

namespace App\Http\Controllers\API;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Continent;
use Illuminate\Support\Arr;

class ContinentCountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\CountryFilter  $filter
     * @param \App\Models\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function index(CountryFilter $filter, Continent $continent)
    {
        $countries = $filter
            ->applyScope('byContinent', Arr::wrap($continent->code))
            ->getPaginator();

        return CountryResource::collection($countries);
    }
}
