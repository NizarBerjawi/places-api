<?php

namespace App\Http\Controllers\Api\V1\Spec;

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
 *
 * @OA\Server(
 *     description="Places API host",
 *     url=BASE_URL
 * )
 *
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 */
class OpenApiSpec
{
}
