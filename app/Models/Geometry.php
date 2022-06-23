<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Flag.
 *
 * @OA\Schema(
 *      schema="geometry",
 *      type="object",
 *      title="Geometry",
 *      @OA\Property(
 *           property="geometry",
 *           type="string",
 *           example="{"type":"MultiPolygon","coordinates":[[[[6.531,-0.002],[6.53,-0.011],[6.523,-0.014]]]]}",
 *           description="A Geometry object represents points, curves, and surfaces in coordinate space."
 *      ),
 * )
 */
class Geometry extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'geoname_id';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'places_shapes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'geometry',
    ];

    /**
     * Get the country that this geometry belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne(Country::class, 'geoname_id');
    }

    /**
     * Get the continent that this geometry belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function continent()
    {
        return $this->hasOneThrough(
            Continent::class,
            Country::class,
            'geoname_id',
            'code',
            'geoname_id',
            'continent_code',
        );
    }
}
