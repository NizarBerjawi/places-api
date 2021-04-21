<?php

namespace App\Http\Controllers\API;

use App\Filters\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CountryResource;
use App\Models\Continent;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        if (! Continent::where('code', $code)->exists()) {
            throw (new ModelNotFoundException)->setModel(Continent::class);
        }

        $countries = $filter
            ->applyScope('byContinent', Arr::wrap($code))
            ->getPaginator();

        return CountryResource::collection($countries);
    }
}
