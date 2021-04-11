<?php

namespace App\Http\Controllers\API;

use App\Filters\FeatureClassFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureClassResource;

class FeatureClassController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\FeatureClassFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(FeatureClassFilter $filter)
    {
        $featureClasses = $filter->getPaginator();

        return FeatureClassResource::collection($featureClasses);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Filters\FeatureClassFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureClassFilter $filter, string $code)
    {
        $featureClass = $filter
            ->getBuilder()
            ->where('code', $code)
            ->first();

        return new FeatureClassResource($featureClass);
    }
}
