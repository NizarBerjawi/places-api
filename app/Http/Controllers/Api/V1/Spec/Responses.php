<?php

namespace App\Http\Controllers\Api\V1\Spec;

/**
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
 *      schema="apiResourceResponse",
 *      type="object",
 *      title="API Resource Response",
 *      allOf={
 *           @OA\Schema(
 *
 *                @OA\Property(
 *                     property="data",
 *                     description="A single resource object",
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
 * @OA\Schema(
 *   schema="errorResponse",
 *   type="object",
 *   title="API Error Response",
 *   description="Malformed or incorrect request from client.",
 *
 *   @OA\Property(
 *        property="errors",
 *        type="object",
 *        @OA\Property(
 *            property="message",
 *            type="string",
 *            example="The specified resource could not be found."
 *        ),
 *        @OA\Property(
 *            property="statusCode",
 *            type="number",
 *            example="404"
 *        )
 *   )
 * ),
 *
 * @OA\Response(
 *   response=401,
 *   description="The client doesn’t have correct authentication credentials.",
 *
 *   @OA\JsonContent(
 *       type="object",
 *
 *       @OA\Property(
 *            property="errors",
 *            type="object",
 *            @OA\Property(
 *                property="message",
 *                type="string",
 *                example="Invalid API key or access token."
 *            ),
 *            @OA\Property(
 *                property="statusCode",
 *                type="number",
 *                example="401"
 *            )
 *       )
 *   )
 * ),
 *
 * @OA\Response(
 *   response=404,
 *   description="Not Found",
 *
 *   @OA\JsonContent(
 *       type="object",
 *
 *       @OA\Property(
 *            property="errors",
 *            type="object",
 *            @OA\Property(
 *                property="message",
 *                type="string",
 *                example="The specified resource could not be found."
 *            ),
 *            @OA\Property(
 *                property="statusCode",
 *                type="number",
 *                example="404"
 *            )
 *       )
 *   )
 * )
 *
 * @OA\Response(
 *   response=429,
 *   description="Too Many Requests",
 *
 *   @OA\JsonContent(
 *       type="object",
 *
 *       @OA\Property(
 *            property="errors",
 *            type="object",
 *            @OA\Property(
 *                property="message",
 *                type="string",
 *                example="Exceeded 25 calls per minute for API client. Reduce request rates to resume uninterrupted service."
 *            ),
 *            @OA\Property(
 *                property="statusCode",
 *                type="number",
 *                example="429"
 *            )
 *       )
 *   )
 * )
 */
class Responses
{
}
