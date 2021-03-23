<?php

namespace App\Http\Controllers\API;

use App\Filters\ContinentFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\ContinentResource;
use App\Models\Continent;

class ContinentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\ContinentFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(ContinentFilter $filter)
    {
        $continents = $filter->getPaginator();

        return ContinentResource::collection($continents);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Continent  $continent
     * @return \Illuminate\Http\Response
     */
    public function show(Continent $continent)
    {
        return new ContinentResource($continent);
    }
}
