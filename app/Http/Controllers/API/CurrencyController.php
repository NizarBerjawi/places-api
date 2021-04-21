<?php

namespace App\Http\Controllers\API;

use App\Filters\CurrencyFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\CurrencyResource;

class CurrencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\CurrencyFilter  $filter
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
     * @param  \App\Filters\CurrencyFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(CurrencyFilter $filter, string $code)
    {
        $currency = $filter
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new CurrencyResource($currency);
    }
}
