<?php

namespace App\Http\Controllers\API;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;
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
        $places = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getPaginator();

        return PlaceResource::collection($places);
    }
}
