<?php

namespace App\Http\Controllers\API;

use App\Filters\FeatureCodeFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\FeatureCodeResource;

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
     * @param  \App\Filters\FeatureCodeFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FeatureCodeFilter $filter, string $code)
    {
        $featureCode = $filter
            ->getBuilder()
            ->where('code', $code)
            ->first();

        return new FeatureCodeResource($featureCode);
    }
}
