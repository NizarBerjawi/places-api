<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Time Zone.
 *
 * @OA\Schema(
 *      schema="timeZone",
 *      type="object",
 *      title="Time Zone",
 *      description="A time zone is an area which observes a uniform standard time for legal, commercial and social purposes. Time zones tend to follow the boundaries between countries and their subdivisions instead of strictly following longitude, because it is convenient for areas in frequent communication to keep the same time",
 *
 *      @OA\Property(
 *           property="gmtOffset",
 *           type="integer",
 *           example="2",
 *           description="The number of hours a place refers to that time zone being three hours "
 *      ),
 *      @OA\Property(
 *           property="timeZone",
 *           type="string",
 *           example="Asia/Tokyo",
 *           description="The time zone name"
 *      ),
 *      @OA\Property(
 *           property="code",
 *           type="string",
 *           example="asia_tokyo",
 *           description="The time zone code"
 *      )
 * )
 */
class TimeZone extends Model
{
    /**
     * The primary key for the model.
     *
     * @OA\Parameter(
     *    parameter="timeZoneCode",
     *    name="timeZoneCode",
     *    in="path",
     *    required=true,
     *    description="The code of the time zone",
     *    example="asia_tokyo",
     *
     *    @OA\Schema(
     *        type="string"
     *    )
     * )
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * The "type" of the primary key time_zone.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'gmt_offset', 'country_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'gmt_offset' => 'float',
    ];

    /**
     * Get the country that belongs to this TimeZone.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'iso3166_alpha2');
    }

    /**
     * Get all the places that belong to this Time Zone.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function places()
    {
        return $this->hasMany(Place::class, 'time_zone_code', 'code');
    }

    /**
     * Get a time zones by its parent country code.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCountry(Builder $query, string $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }

    /**
     * Get a time zones by code.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByTimeZoneCode(Builder $query, string $timeZoneCode)
    {
        return $query->where('code', $timeZoneCode);
    }
}
