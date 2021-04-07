<?php

namespace App\Http\Controllers\API;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
use App\Models\Country;
use Illuminate\Support\Arr;

class CountryPlacesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\FlagFilter  $filter
     * @param  \App\Models\Country      $country
     * @return \Illuminate\Http\Response
     */
    public function index(PlaceFilter $filter, Country $country)
    {
        $places = $filter
            ->applyScope('byCountry', Arr::wrap($country->iso3166_alpha2))
            ->getPaginator();
        
        return PlaceResource::collection($places);
    }
}
