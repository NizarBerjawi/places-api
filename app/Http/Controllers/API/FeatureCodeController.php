<?php

namespace App\Http\Controllers\API;

use App\Filters\FeatureCodeFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureCodeResource;
use App\Models\FeatureCode;

class FeatureCodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\FeatureCodeFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(FeatureCodeFilter $filter)
    {
        $featureCodes = $filter->getPaginator();

        return FeatureCodeResource::collection($featureCodes);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\FeatureCode $featureCode
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureCode $featureCode)
    {
        return new FeatureCodeResource($featureCode);
    }
}
