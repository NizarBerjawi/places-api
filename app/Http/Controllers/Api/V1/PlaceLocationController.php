<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\LocationFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\LocationResource;
use App\Models\Place;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
        if (! Place::where('uuid', $uuid)->exists()) {
            throw (new ModelNotFoundException())->setModel(Country::class);
        }

        $location = $filter
            ->applyScope('byPlace', Arr::wrap($uuid))
            ->getBuilder()
            ->first();

        return LocationResource::make($location);
    }
}
