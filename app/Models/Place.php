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
 *      title="Place"
 * )
 * @OA\Property(
 *      property="elevation",
 *      type="integer",
 *      example="2209",
 *      description="The elevation of a place in meters"
 * )
 * @OA\Property(
 *      property="name",
 *      type="string",
 *      example="Mount Townsend",
 *      description="The name of a place"
 * )
 * @OA\Property(
 *      property="population",
 *      type="integer",
 *      example="0",
 *      description="The population of a certain place"
 * )
 * @OA\Property(
 *      property="geoname_id",
 *      type="integer",
 *      example="105480",
 *      description="The Geoname ID of a certain place"
 * )
 */
class Place extends Model
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
     * @return \Illuminate\Database\Eloquent\Relations\MorphOne
     */
    public function location()
    {
        return $this->morphOne(Location::class, 'locationable');
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
     * Get places with area greater than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeAreaGt(Builder $query, float $value)
    {
        return $query->where('area', '>', $value);
    }

    /**
     * Get countries with population greater than a specified
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
     * Get countries with population greater than or equal to a
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
     * Get countries with population less than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePopulationLt(Builder $query, int $value)
    {
        return $query->where('population', '<', $value);
    }

    /**
     * Get countries with population less than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePopulationLte(Builder $query, int $value)
    {
        return $query->where('population', '<=', $value);
    }

    /**
     * Get countries with population between two specified values.
     *
     * @param \Illuminate\Database\Eloquent\Builder $query
     * @param float $min
     * @param float $max
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopePopulationBetween(Builder $query, int $min, int $max)
    {
        return $query
            ->populationGte($min)
            ->populationLte($max);
    }
}
