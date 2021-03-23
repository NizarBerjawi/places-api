<?php

namespace App\Http\Controllers\API;

use App\Filters\FeatureClassFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureClassResource;
use App\Models\FeatureClass;

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
     * @param  \App\Models\FeatureClass  $featureClass
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureClass $featureClass)
    {
        return new FeatureClassResource($featureClass);
    }
}
