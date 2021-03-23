<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    /**
     * The primary key for the model.
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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'iso3166_alpha2',
        'iso3166_alpha3',
        'iso3166_numeric',
        'population',
        'area',
        'phone_code',
        'continent_code',
    ];

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
        return $this->belongsToMany(self::class, 'country_neighbour', 'neighbour_code', 'country_code', 'iso3166_alpha2', 'iso3166_alpha2');
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
        return $this->belongsToMany(Language::class, null, 'country_code', null, 'iso3166_alpha2');
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
     * Get the official currency used in this Country.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
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
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function timeZones()
    {
        return $this->hasMany(TimeZone::class, 'country_code', 'iso3166_alpha2');
    }

    /**
     * Get Countries by continent code
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $continentCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByContinent(Builder $query, $continentCode)
    {
        return $query->whereHas('continent', function (Builder $query) use ($continentCode) {
            $query->where('continent_code', $continentCode);
        });
    }

    /**
     * Get countries with area greater than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeAreaGt(Builder $query, float $value)
    {
        return $query->where('area', '>', $value);
    }

    /**
     * Get countries with area greater than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeAreaGte(Builder $query, float $value)
    {
        return $query->where('area', '>=', $value);
    }

    /**
     * Get countries with area less than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeAreaLt(Builder $query, float $value)
    {
        return $query->where('area', '<', $value);
    }

    /**
     * Get countries with area less than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeAreaLte(Builder $query, float $value)
    {
        return $query->where('area', '<=', $value);
    }

    /**
     * Get countries with area between two specified values.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param float $min
     * @param float $max
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeAreaBetween(Builder $query, float $min, float $max)
    {
        return $query
            ->areaGte($min)
            ->areaLte($max);
    }

    /**
     * Get countries with population greater than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopePopulationGt(Builder $query, int $value)
    {
        return $query->where('population', '>', $value);
    }

    /**
     * Get countries with population greater than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param int $value
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopePopulationGte(Builder $query, int $value)
    {
        return $query->where('population', '>=', $value);
    }

    /**
     * Get countries with population less than a specified
     * value.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopePopulationLt(Builder $query, int $value)
    {
        return $query->where('population', '<', $value);
    }

    /**
     * Get countries with population less than or equal to a
     * specified value.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param float $value
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopePopulationLte(Builder $query, int $value)
    {
        return $query->where('population', '<=', $value);
    }

    /**
     * Get countries with population between two specified values.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param float $min
     * @param float $max
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopePopulationBetween(Builder $query, int $min, int $max)
    {
        return $query
            ->populationGte($min)
            ->populationLte($max);
    }
}
