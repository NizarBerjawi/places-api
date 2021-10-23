<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Place.
 *
 * @OA\Schema(
 *      schema="place",
 *      type="object",
 *      title="Place",
 *      @OA\Property(
 *           property="geonameId",
 *           type="integer",
 *           example="105480",
 *           description="The Geoname ID of a certain place"
 *      ),
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Jāl Jahlān",
 *           description="The name of a place"
 *      ),
 *      @OA\Property(
 *           property="asciiName",
 *           type="string",
 *           example="Jal Jahlan",
 *           description="The ASCII name of a place"
 *      ),
 *      @OA\Property(
 *           property="population",
 *           type="integer",
 *           example="0",
 *           description="The population of a certain place"
 *      ),
 *      @OA\Property(
 *           property="elevation",
 *           type="integer",
 *           example="0",
 *           description="The elevation of a place in meters"
 *      ),
 *      @OA\Property(
 *           property="dem",
 *           type="integer",
 *           example="79",
 *           description="The digital elevation model of a place in meters"
 *      ),
 * )
 */
class Place extends Model
{
    /**
     * The primary key for the model.
     *
     * @OA\Parameter(
     *    parameter="geonameId",
     *    name="geonameId",
     *    in="path",
     *    required=true,
     *    description="The Geoname ID of the place",
     *    @OA\Schema(
     *        type="string"
     *    )
     * )
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
        'name', 'population', 'elevation',
    ];

    /**
     * Get the Feature Code that this Place belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function featureCode()
    {
        return $this->belongsTo(FeatureCode::class, 'feature_code', 'code');
    }

    /**
     * Get the Feature Class that this place belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function featureClass()
    {
        return $this->belongsToMany(
            FeatureClass::class,
            'feature_codes',
            'code',
            'feature_class_code',
            'feature_code',
            'code'
        );
    }

    /**
     * Get the Time Zone that this Place belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class, 'time_zone_code', 'code');
    }

    /**
     * Get the Country that this Place belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'iso3166_alpha2');
    }

    /**
     * Get the Location of this Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne(Location::class, 'geoname_id');
    }

    /**
     * Get the alternate names belonging to this place.
     *
     * @param string $value
     * @return array
     */
    public function alternateNames()
    {
        return $this->hasMany(AlternateName::class, 'geoname_id');
    }

    /**
     * Get places scoped by geoname id.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int  $geonameId
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByGeonameId(Builder $query, int $geonameId)
    {
        return $query->where('geoname_id', $geonameId);
    }

    /**
     * Get places scoped by country.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param string  $countryCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCountry(Builder $query, string $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }

    /**
     * Get places with elevation greater than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeElevationGt(Builder $query, int $value)
    {
        return $query->where('elevation', '>', $value);
    }

    /**
     * Get places with elevation greater than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeElevationGte(Builder $query, int $value)
    {
        return $query->where('elevation', '>=', $value);
    }

    /**
     * Get places with elevation less than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int  $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeElevationLt(Builder $query, int $value)
    {
        return $query->where('elevation', '<', $value);
    }

    /**
     * Get places with elevation less than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeElevationLte(Builder $query, int $value)
    {
        return $query->where('elevation', '<=', $value);
    }

    /**
     * Get places with elevation between two specified values.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $min
     * @param int $max
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeElevationBetween(Builder $query, int $min, int $max)
    {
        return $query
            ->elevationGte($min)
            ->elevationLte($max);
    }

    /**
     * Get places with population greater than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePopulationGt(Builder $query, int $value)
    {
        return $query->where('population', '>', $value);
    }

    /**
     * Get places with population greater than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePopulationGte(Builder $query, int $value)
    {
        return $query->where('population', '>=', $value);
    }

    /**
     * Get places with population less than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePopulationLt(Builder $query, int $value)
    {
        return $query->where('population', '<', $value);
    }

    /**
     * Get places with population less than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePopulationLte(Builder $query, int $value)
    {
        return $query->where('population', '<=', $value);
    }

    /**
     * Get places with population between two specified values.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param int $min
     * @param int $max
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePopulationBetween(Builder $query, int $min, int $max)
    {
        return $query
            ->populationGte($min)
            ->populationLte($max);
    }
}
