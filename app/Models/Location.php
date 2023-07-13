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
 *      title="Location",
 *
 *      @OA\Property(
 *           property="latitude",
 *           type="number",
 *           example="-25.734968",
 *           description="The latitude of a certain place"
 *      ),
 *      @OA\Property(
 *           property="longitude",
 *           type="number",
 *           example="134.489563",
 *           description="The longitude of a certain place"
 *      ),
 * )
 */
class Location extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'geoname_id';

    /**
     * The "type" of the primary key geoname_id.
     *
     * @var string
     */
    protected $keyType = 'integer';

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
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeByPlace(Builder $query, int $geonameId)
    {
        return $query->where('geoname_id', $geonameId);
    }
}
