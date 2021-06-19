<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Location.
 *
 * @OA\Schema(
 *      schema="location",
 *      type="object",
 *      title="Location"
 * )
 * @OA\Property(
 *      property="latitude",
 *      type="string",
 *      example="-25.734968",
 *      description="The latitude of a certain place"
 * )
 * @OA\Property(
 *      property="longitude",
 *      type="string",
 *      example="134.489563",
 *      description="The longitude of a certain place"
 * )
 */
class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude', 'longitude',
    ];

    /**
     * Get the owning locationable model.
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function locationable()
    {
        return $this->morphTo();
    }

    /**
     * Get locations by place.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $uuid
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeByPlace(Builder $query, string $uuid)
    {
        return $query
            ->where('locationable_id', $uuid)
            ->where('locationable_type', Place::class);
    }
}
