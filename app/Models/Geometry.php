<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Geometry.
 *
 * @OA\Schema(
 *      schema="geometry",
 *      type="object",
 *      title="Geometry",
 *      @OA\Property(
 *           property="type",
 *           type="string",
 *           example="Polygon",
 *           description="The type of the GeoJSON object."
 *      ),
 *      @OA\Property(
 *           property="coordinates",
 *           type="string",
 *           example="[[[[6.531,-0.002],[6.53,-0.011],[6.523,-0.014]]]]",
 *           description="Coordinates represent points, curves, and surfaces in coordinate space."
 *      ),
 * )
 *
 * @OA\Schema(
 *      schema="feature",
 *      type="object",
 *      title="Feature",
 *      @OA\Property(
 *           property="type",
 *           type="string",
 *           example="Feature",
 *           description="The type of the GeoJSON object."
 *      ),
 *      @OA\Property(
 *           property="properties",
 *           ref="#/components/schemas/country"
 *      ),
 *      @OA\Property(
 *           property="geometry",
 *           ref="#/components/schemas/geometry"
 *      )
 * )
 *
 * @OA\Schema(
 *      schema="featureCollection",
 *      type="object",
 *      title="Feature Collection",
 *      @OA\Property(
 *           property="type",
 *           type="string",
 *           example="FeatureCollection",
 *           description="The type of the GeoJSON object."
 *      ),
 *      @OA\Property(
 *           property="features",
 *           type="array",
 *           @OA\Items(ref="#/components/schemas/feature")
 *      )
 * )
 */
class Geometry extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'country_code';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

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
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'geometry' => 'array',
    ];

    /**
     * Get the country that this geometry belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->hasOne(Country::class, 'iso3166_alpha2');
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
            'iso3166_alpha2',
            'code',
            'country_code',
            'continent_code',
        );
    }

    /**
     * Get a Geometry by country code.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $countryCode
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeByCountryCode(Builder $query, string $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }
}
