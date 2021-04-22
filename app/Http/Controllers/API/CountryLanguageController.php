<?php

namespace App\Http\Controllers\API;

use App\Filters\LanguageFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;
use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryLanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\LanguageFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(LanguageFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $language = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getPaginator();

        return LanguageResource::collection($language);
    }
}
