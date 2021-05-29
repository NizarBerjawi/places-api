<?php

namespace App\Http\Controllers\Api\V1;

use App\Filters\FlagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\FlagResource;

class FlagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param \App\Filters\FlagFilter  $filter
     * @return \Illuminate\Http\Response
     */
    public function index(FlagFilter $filter)
    {
        $flags = $filter->getPaginator();

        return FlagResource::collection($flags);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Filters\FlagFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function show(FlagFilter $filter, string $code)
    {
        $flag = $filter
            ->getBuilder()
            ->where('country_code', $code)
            ->firstOrFail();

        return new FlagResource($flag);
    }
}
