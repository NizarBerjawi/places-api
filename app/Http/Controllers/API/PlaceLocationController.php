<?php

namespace App\Http\Controllers\API;

use App\Filters\LocationFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\LocationResource;
use Illuminate\Support\Arr;

class PlaceLocationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\PlaceFilter  $filter
     * @param string $uuid
     * @return \Illuminate\Http\Response
     */
    public function index(LocationFilter $filter, string $uuid)
    {
        $places = $filter
            ->applyScope('byPlace', Arr::wrap($uuid))
            ->getPaginator();

        return LocationResource::collection($places);
    }
}
