<?php

namespace App\Http\Controllers\API;

use App\Filters\CurrencyFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;
use App\Models\Currency;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CurrencyFilter $filter)
    {
        $currencies = $filter->getPaginator();

        return CurrencyResource::collection($currencies);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Currency $Currency)
    {
        return new CurrencyResource($Currency);
    }
}
