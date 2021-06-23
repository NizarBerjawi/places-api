<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Time Zone.
 *
 * @OA\Schema(
 *      schema="time_zone",
 *      type="object",
 *      title="Time Zone"
 * )
 * @OA\Property(
 *      property="gmt_offset",
 *      type="integer",
 *      example="2",
 *      description="The number of hours a place refers to that time zone being three hours "
 * )
 * @OA\Property(
 *      property="time_zone",
 *      type="string",
 *      example="Asia/Tokyo",
 *      description="The time one name"
 * )
 * @OA\Property(
 *      property="code",
 *      type="string",
 *      example="asia_tokyo",
 *      description="The time zone name"
 * )
 */
class TimeZone extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'gmt_offset',
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
     * Get all the countries that belong to this TimeZone.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'iso3166_alpha2');
    }

    /**
     * Get a time zones by its parent country code.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $countryCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCountry(Builder $query, string $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }
}
