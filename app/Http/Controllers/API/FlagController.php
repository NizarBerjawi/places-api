<?php

namespace App\Http\Controllers\API;

use App\Filters\FlagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\FlagResource;
use App\Models\Flag;

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
        $flags= $filter->getPaginator();

        return FlagResource::collection($flags);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Flag $flag
     * @return \Illuminate\Http\Response
     */
    public function show(Flag $flag)
    {
        return new FlagResource($flag);
    }
}
