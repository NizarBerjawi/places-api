<?php

namespace App\Http\Controllers\API;

use App\Filters\LanguageFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Country;
use Illuminate\Support\Arr;

class CountryLanguageController extends Controller
{
    /**
    * Display a listing of the resource.
    *
    * @param  \App\Filters\LanguageFilter  $filter
    * @param  \App\Models\Country          $country
    * @return \Illuminate\Http\Response
    */
    public function index(LanguageFilter $filter, Country $country)
    {
        $language = $filter
            ->applyScope('byCountry', Arr::wrap($country->iso3166_alpha2))
            ->getPaginator();

        return LanguageResource::collection($language);
    }
}
