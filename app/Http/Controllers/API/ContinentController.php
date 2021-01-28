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
     * @return \Illuminate\Http\Response
     */
    public function index(ContinentFilter $filter)
    {
        $continents = $filter->getBuilder()->get();

        return ContinentResource::collection($continents);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Continent $continent)
    {
        return new ContinentResource($continent);
    }
}
