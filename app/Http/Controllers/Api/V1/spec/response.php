<?php

/**
 * @OA\Schema(
 *      schema="apiResponse",
 *      type="object",
 *      title="Api Response",
 *      allOf={
 *           @OA\Schema(
 *                @OA\Property(
 *                     property="data",
 *                     description="The paginated data set that is returned.",
 *                     oneOf={
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
 *                ),
 *                @OA\Property(
 *                     property="links",
 *                     type="object",
 *                     description="Determines if the alternate name is official/preferred.",
 *                     @OA\Property(
 *                          property="first",
 *                          type="string",
 *                          example="https://placesapi.dev/api/v1/featureClasses?page=1",
 *                          description="The first page of the paginated data set."
 *                     ),
 *                     @OA\Property(
 *                          property="last",
 *                          type="null",
 *                          example="null",
 *                          description="For performance reasons, this will always be null."
 *                     ),
 *                     @OA\Property(
 *                          property="prev",
 *                          type="string",
 *                          example="https://placesapi.dev/api/v1/featureClasses?page=2",
 *                          description="The previous page of the paginated data set."
 *                     ),
 *                     @OA\Property(
 *                          property="next",
 *                          type="string",
 *                          example="https://placesapi.dev/api/v1/featureClasses?page=4",
 *                          description="The next page in the paginated data set."
 *                     ),
 *                ),
 *                @OA\Property(
 *                     property="meta",
 *                     type="object",
 *                     description="Determines if the alternate name is official/preferred.",
 *                     @OA\Property(
 *                          property="currentPage",
 *                          type="integer",
 *                          example="3",
 *                          description="The number of the current page of data."
 *                     ),
 *                     @OA\Property(
 *                          property="from",
 *                          type="integer",
 *                          example="21",
 *                          description="The index of the first item on the current page relative to all the data set."
 *                     ),
 *                     @OA\Property(
 *                          property="path",
 *                          type="string",
 *                          example="https://placesapi.dev/api/v1/featureClasses",
 *                          description="The base path of the data that is being paginated."
 *                     ),
 *                     @OA\Property(
 *                          property="perPage",
 *                          type="string",
 *                          example="10",
 *                          description="The number of items per page."
 *                     ),
 *                     @OA\Property(
 *                          property="to",
 *                          type="integer",
 *                          example="30",
 *                          description="The index of the last item on the current page relative to all the data set."
 *                     ),
 *                )
 *           )
 *      }
 * )
 */
