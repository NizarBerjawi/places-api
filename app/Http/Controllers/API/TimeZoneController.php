<?php

namespace App\Http\Controllers\API;

use App\Filters\TimeZoneFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\TimeZoneResource;

class TimeZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\TimeZoneFilter  $filter
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
     * @param \App\Filters\TimeZoneFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(TimeZoneFilter $filter, string $code)
    {
        $timeZone = $filter
            ->getBuilder()
            ->where('code', $code)
            ->firstOrFail();

        return new TimeZoneResource($timeZone);
    }
}
