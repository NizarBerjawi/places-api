<?php

namespace App\Models;

/**
 * Statistics.
 *
 * @OA\Schema(
 *      schema="statistics",
 *      type="object",
 *      title="Statistics",
 *      description="Statistics about the resources available through the API",
 *
 *      @OA\Property(
 *           property="id",
 *           type="string",
 *           format="uid",
 *           description="The uid of this statistic."
 *      ),
 *      @OA\Property(
 *           property="type",
 *           type="string",
 *           example="count",
 *           description="The type of the statistic provided"
 *      ),
 *      @OA\Property(
 *           property="label",
 *           type="string",
 *           example="Places",
 *           description="A descriptive label for the statistic."
 *      ),
 *      @OA\Property(
 *           property="value",
 *           type="number",
 *           example="680",
 *           description="The value of the statistic"
 *      )
 * )
 */
class Statistics
{
    //
}
