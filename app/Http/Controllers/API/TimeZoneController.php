<?php

namespace App\Http\Controllers\API;

use App\Filters\TimeZoneFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\TimeZoneResource;
use App\Models\TimeZone;

class TimeZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TimeZoneFilter $filter)
    {
        $timeZones = $filter->getPaginator();

        return TimeZoneResource::collection($timeZones);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(TimeZone $timeZone)
    {
        return new TimeZoneResource($timeZone);
    }
}
