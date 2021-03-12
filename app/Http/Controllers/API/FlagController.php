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
    * @return \Illuminate\Http\Response
    */
    public function index(FlagFilter $filter)
    {
        $flags= $filter->getBuilder();

        return FlagResource::collection($flags);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Flag $flag)
    {
        return new FlagResource($flag);
    }
}
