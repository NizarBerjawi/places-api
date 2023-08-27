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
 *
 * @OA\Schema(
 *      schema="apiCollectionResponse",
 *      type="object",
 *      title="API Collection Response",
 *      allOf={
 *           @OA\Schema(
 *
 *                @OA\Property(
 *                     property="data",
 *                     description="A paginated collection of objects.",
 *                     type="array",
 *
 *                     @OA\Items(
 *                          type="object",
 *                          oneOf={
 *
 *                                @OA\Schema(ref="#/components/schemas/alternateName"),
 *                                @OA\Schema(ref="#/components/schemas/continent"),
 *                                @OA\Schema(ref="#/components/schemas/country"),
 *                                @OA\Schema(ref="#/components/schemas/currency"),
 *                                @OA\Schema(ref="#/components/schemas/featureClass"),
 *                                @OA\Schema(ref="#/components/schemas/featureCode"),
 *                                @OA\Schema(ref="#/components/schemas/flag"),
 *                                @OA\Schema(ref="#/components/schemas/language"),
 *                                @OA\Schema(ref="#/components/schemas/place"),
 *                                @OA\Schema(ref="#/components/schemas/timeZone"),
 *                          }
 *                     )
 *                ),
 *
 *                @OA\Property(
 *                     property="links",
 *                     type="object",
 *                     description="Display the links to other pages of the response",
 *                     @OA\Property(
 *                          property="prev",
 *                          type="string",
 *                          example=PREV,
 *                          description="The previous page of the paginated data set."
 *                     ),
 *                     @OA\Property(
 *                          property="next",
 *                          type="string",
 *                          example=NEXT,
 *                          description="The next page in the paginated data set."
 *                     ),
 *                ),
 *                @OA\Property(
 *                     property="meta",
 *                     type="object",
 *                     description="Meta data related to paginated responses.",
 *                     @OA\Property(
 *                          property="path",
 *                          type="string",
 *                          example=PAGE_PATH,
 *                          description="The base path of the data that is being paginated."
 *                     ),
 *                     @OA\Property(
 *                          property="perPage",
 *                          type="string",
 *                          example="10",
 *                          description="The number of items per page."
 *                     ),
 *                     @OA\Property(
 *                          property="nextCursor",
 *                          type="string",
 *                          example="eyJpc28zMTY2X2FscGhhMiI6IkJPIiwiX3BvaW50c1RvTmV4dEl0ZW1zIjp0cnVlfQ",
 *                          description="The cursor to the next paginated set of data"
 *                     ),
 *                     @OA\Property(
 *                          property="prevCursor",
 *                          type="string",
 *                          example="eyJpc28zMTY2X2FscGhhMiI6IkJFIiwiX3BvaW50c1RvTmV4dEl0ZW1zIjpmYWxzZX0",
 *                          description="The cursor to the previous paginated set of data"
 *                     ),
 *                )
 *           )
 *      }
 * )
 *
 * @OA\Schema(
 *      schema="apiObjectResponse",
 *      type="object",
 *      title="API Object Response",
 *      allOf={
 *           @OA\Schema(
 *
 *                @OA\Property(
 *                     property="data",
 *                     description="A single data object",
 *                     type="object",
 *                     oneOf={
 *
 *                           @OA\Schema(ref="#/components/schemas/alternateName"),
 *                           @OA\Schema(ref="#/components/schemas/continent"),
 *                           @OA\Schema(ref="#/components/schemas/country"),
 *                           @OA\Schema(ref="#/components/schemas/currency"),
 *                           @OA\Schema(ref="#/components/schemas/featureClass"),
 *                           @OA\Schema(ref="#/components/schemas/featureCode"),
 *                           @OA\Schema(ref="#/components/schemas/flag"),
 *                           @OA\Schema(ref="#/components/schemas/language"),
 *                           @OA\Schema(ref="#/components/schemas/place"),
 *                           @OA\Schema(ref="#/components/schemas/timeZone"),
 *                     }
 *                )
 *           )
 *      }
 * )
 */
class OpenApiSpec
{
}
