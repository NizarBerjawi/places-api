<?php

namespace App\Http\Controllers\API;

use App\Models\Country;
use App\Http\Resources\{CountryResource, CountryCollection};
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\QueryBuilder\QueryBuilder;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = QueryBuilder::for(Country::class)
            ->allowedFilters(Country::$allowedFilters)
            ->get();

        return CountryResource::collection($countries);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Country $country)
    {
        return new CountryResource($country);
    }
}
