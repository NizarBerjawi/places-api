<?php

namespace App\Http\Controllers\API;

use App\Filters\CurrencyFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Models\Country;
use Illuminate\Support\Arr;

class CountryCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\CurrencyFilter  $filter
     * @param  \App\Models\Country          $country
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyFilter $filter, Country $country)
    {
        $currency = $filter
            ->applyScope('byCountry', Arr::wrap($country->iso3166_alpha2))
            ->getBuilder()
            ->first();

        return CurrencyResource::make($currency);
    }
}
