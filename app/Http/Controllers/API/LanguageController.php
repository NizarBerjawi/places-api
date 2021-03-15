<?php

namespace App\Http\Controllers\API;

use App\Filters\LanguageFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\LanguageResource;

class LanguageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(LanguageFilter $filter)
    {
        $languages = $filter->getPaginator();

        return LanguageResource::collection($languages);
    }
}
