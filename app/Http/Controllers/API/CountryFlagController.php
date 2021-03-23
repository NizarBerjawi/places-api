<?php

namespace App\Http\Controllers\API;

use App\Filters\FlagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\FlagResource;
use App\Models\Country;
use Illuminate\Support\Arr;

class CountryFlagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\FlagFilter  $filter
     * @param  \App\Models\Country      $country
     * @return \Illuminate\Http\Response
     */
    public function index(FlagFilter $filter, Country $country)
    {
        $flag = $filter
            ->applyScope('byCountry', Arr::wrap($country->iso3166_alpha2))
            ->getBuilder()
            ->first();
        
        return FlagResource::make($flag);
    }
}
