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
     * @return \Illuminate\Http\Response
     */
    public function index(FeatureClassFilter $filter)
    {
        $featureClasses = $filter->getBuilder()->get();
        
        return FeatureClassResource::collection($featureClasses);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureClass $featureClass)
    {
        return new FeatureClassResource($featureClass);
    }
}
