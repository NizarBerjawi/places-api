<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\CurrencyFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CurrencyResource;
use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryCurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\CurrencyFilter $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $currency = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getBuilder()
            ->first();

        return CurrencyResource::make($currency);
    }
}
