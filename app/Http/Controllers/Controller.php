<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * @OA\Info(
     *     title="Places API",
     *     version="1.0.0",
     *     description="This is the full documentation for the Places API.",
     *
     *     @OA\Contact(
     *         email="nizarberjawi12@gmail.com"
     *     )
     * )
     */
}
