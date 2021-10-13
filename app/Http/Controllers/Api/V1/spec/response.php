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
 *                          example=FIRST,
 *                          description="The first page of the paginated data set."
 *                     ),
 *                     @OA\Property(
 *                          property="last",
 *                          type="string",
 *                          example=LAST,
 *                          description="The last page in the paginated data set."
 *                     ),
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
 *                          property="lastPage",
 *                          type="integer",
 *                          example="21",
 *                          description="The last possible page in this data set."
 *                     ),
 *                     @OA\Property(
 *                         property="links",
 *                         type="array",
 *                         description="",
 *                         @OA\Items(
 *                             @OA\Property(
 *                                  property="url",
 *                                  type="string",
 *                                  example=PAGE_URL,
 *                                  description="The url to this pagination item."
 *                             ),
 *                             @OA\Property(
 *                                  property="label",
 *                                  type="string",
 *                                  example="10",
 *                                  description="The pagination label."
 *                             ),
 *                             @OA\Property(
 *                                  property="active",
 *                                  type="boolean",
 *                                  example="true",
 *                                  description="Determines whether the current URL is active or not."
 *                             ),
 *                         )
 *
 *                      ),
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
 *                          property="to",
 *                          type="integer",
 *                          example="30",
 *                          description="The index of the last item on the current page relative to all the data set."
 *                     ),
 *                     @OA\Property(
 *                          property="total",
 *                          type="integer",
 *                          example="680",
 *                          description="The count of all the items in the data set regardless of pagination."
 *                     ),
 *                )
 *           )
 *      }
 * )
 */
