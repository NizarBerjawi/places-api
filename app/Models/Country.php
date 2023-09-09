<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Country.
 *
 * @OA\Schema(
 *      schema="country",
 *      type="object",
 *      title="Country",
 *      description="A country is a distinct part of the world, such as a state, nation, or other political entity. It may be a sovereign state or make up one part of a larger state.",
 *
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Australia",
 *           description="The English name of the country"
 *      ),
 *      @OA\Property(
 *           property="iso3166Alpha2",
 *           type="string",
 *           example="AU",
 *           description="The two-letter ISO 3166-1 alpha-2 country code"
 *      ),
 *      @OA\Property(
 *           property="iso3166Alpha3",
 *           type="string",
 *           example="AUS",
 *           description="The three-letter ISO 3166-1 alpha-3 country code"
 *      ),
 *      @OA\Property(
 *           property="iso3166Numeric",
 *           type="integer",
 *           example="036",
 *           description="The three-digit ISO 3166-1 numeric country code"
 *      ),
 *      @OA\Property(
 *           property="population",
 *           type="integer",
 *           example="24992369",
 *           description="The population of the country"
 *      ),
 *      @OA\Property(
 *           property="area",
 *           type="number",
 *           format="float",
 *           example="7686850",
 *           description="The total area of the country"
 *      ),
 *      @OA\Property(
 *           property="phoneCode",
 *           type="string",
 *           nullable=true,
 *           example="61",
 *           description="The country calling code"
 *      )
 * )
 */
class Country extends Model
{
    /**
     * The primary key for the model.
     *
     * @OA\Parameter(
     *    parameter="countryCode",
     *    name="countryCode",
     *    in="path",
     *    required=true,
     *    description="The iso3166Alpha2 code of the country",
     *    example="AU",
     *
     *    @OA\Schema(
     *        type="string"
     *    )
     * )
     *
     * @var string
     */
    protected $primaryKey = 'iso3166_alpha2';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * The relations to eager load on every query.
     *
     * @var array
     */
    protected $with = ['place'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'iso3166_alpha2',
        'iso3166_alpha3',
        'iso3166_numeric',
        'fips',
        'topLevelDomain',
        'population',
        'area',
        'phone_code',
        'continent_code',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'iso3166_numeric' => 'integer',
        'population' => 'integer',
        'area' => 'float',
    ];

    /**
     * Get the country's population.
     *
     * @param  string  $value
     * @return string
     */
    public function getPopulationAttribute($value)
    {
        if (! $this->relationLoaded('place') || empty($this->place)) {
            return $value;
        }

        return $this->place->population;
    }

    /**
     * Get the continent that owns this country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function continent()
    {
        return $this->belongsTo(Continent::class, 'continent_code', 'code');
    }

    /**
     * Get all the neighbouring countries of this country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function neighbours()
    {
        return $this->belongsToMany(
            self::class,
            'country_neighbour',
            'neighbour_code',
            'country_code',
            'iso3166_alpha2',
            'iso3166_alpha2'
        );
    }

    /**
     * Get the flag associated with this country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function flag()
    {
        return $this->hasOne(Flag::class, 'country_code');
    }

    /**
     * Get all the languages associated with a country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function languages()
    {
        return $this->belongsToMany(
            Language::class,
            null,
            'country_code',
            'language_code',
            'iso3166_alpha2'
        );
    }

    /**
     * Get all the Places that belong to this Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function places()
    {
        return $this->hasMany(Place::class, 'country_code', 'iso3166_alpha2');
    }

    /**
     * Get the corresponding place data of the country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function place()
    {
        return $this->hasOne(Place::class, 'geoname_id', 'geoname_id');
    }

    /**
     * Get the alternate names belonging to this country.
     *
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function alternateNames()
    {
        return $this->hasManyThrough(
            AlternateName::class,
            Place::class,
            'geoname_id',
            'geoname_id',
            'geoname_id'
        );
    }

    /**
     * Get the official currency used in this Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function currency()
    {
        return $this->hasOneThrough(
            Currency::class,
            CountryCurrency::class,
            'country_code',
            'code',
            'iso3166_alpha2',
            'currency_code'
        );
    }

    /**
     * Get the TimeZones belonging to this Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function timeZones()
    {
        return $this->hasMany(TimeZone::class, 'country_code', 'iso3166_alpha2');
    }

    /**
     * Get the Location of this Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOneThrough
     */
    public function location()
    {
        return $this->hasOneThrough(
            Location::class,
            Place::class,
            'geoname_id',
            'geoname_id',
            'geoname_id'
        );
    }

    /**
     * Get the Geometry of this Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function geometry()
    {
        return $this->belongsTo(Geometry::class, 'iso3166_alpha2');
    }

    /**
     * Determine if a country is dissolved.
     *
     * @return bool
     */
    public function getIsDissolvedAttribute()
    {
        return in_array($this->iso3166_alpha2, ['AN', 'CS']);
    }

    /**
     * Get Countries by continent code.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByContinentCode(Builder $query, string $continentCode)
    {
        return $query->where('continent_code', $continentCode);
    }

    /**
     * Get Countries by country code.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCountryCode(Builder $query, string $countryCode)
    {
        return $query->where('iso3166_alpha2', $countryCode);
    }

    /**
     * Get any country that is a neighbour of the specified country.
     *
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeNeighbourOf(Builder $query, string $code)
    {
        return $query
            ->whereHas('neighbours', function (Builder $query) use ($code) {
                $query->where('country_code', $code);
            });
    }
}
