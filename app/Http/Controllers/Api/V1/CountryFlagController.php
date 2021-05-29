<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\FlagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FlagResource;
use App\Models\Country;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Arr;

class CountryFlagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\FlagFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(FlagFilter $filter, string $code)
    {
        if (! Country::where('iso3166_alpha2', $code)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $flag = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getBuilder()
            ->first();

        return FlagResource::make($flag);
    }
}
