<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\ContinentFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ContinentResource;

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
     * @param \App\Filters\ContinentFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(ContinentFilter $filter, string $code)
    {
        $continent = $filter
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new ContinentResource($continent);
    }
}
