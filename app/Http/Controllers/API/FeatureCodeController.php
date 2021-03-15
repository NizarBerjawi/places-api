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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureCode $featureCode)
    {
        return new FeatureCodeResource($featureCode);
    }
}
