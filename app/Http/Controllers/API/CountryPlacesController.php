<?php

namespace App\Http\Controllers\API;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryPlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\FlagFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(PlaceFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $places = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getPaginator();

        return PlaceResource::collection($places);
    }
}
