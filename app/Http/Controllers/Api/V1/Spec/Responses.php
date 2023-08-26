<?php

namespace App\Http\Controllers\Api\V1\Spec;

/**
 * @OA\Schema(
 *   schema="errorResponse",
 *   type="object",
 *   title="Error Response",
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
