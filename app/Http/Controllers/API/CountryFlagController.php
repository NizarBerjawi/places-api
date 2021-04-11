<?php

namespace App\Http\Controllers\API;

use App\Filters\FlagFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\FlagResource;
use Illuminate\Support\Arr;

class CountryFlagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Filters\FlagFilter  $filter
     * @param  string $code
     * @return \Illuminate\Http\Response
     */
    public function index(FlagFilter $filter, string $code)
    {
        $flag = $filter
            ->applyScope('byCountry', Arr::wrap($code))
            ->getBuilder()
            ->first();
        
        return FlagResource::make($flag);
    }
}
