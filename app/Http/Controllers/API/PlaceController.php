<?php

namespace App\Http\Controllers\API;

use App\Filters\PlaceFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\PlaceResource;

class PlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\PlaceFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(PlaceFilter $filter)
    {
        $places = $filter->getPaginator();

        return PlaceResource::collection($places);
    }

    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\PlaceFilter  $filter
     * @param string $uuid
     * @return \Illuminate\Http\Response
     */
    public function show(PlaceFilter $filter, string $uuid)
    {
        $place = $filter
            ->getBuilder()
            ->where('uuid', $uuid)
            ->first();

        return PlaceResource::make($place);
    }
}
