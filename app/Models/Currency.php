<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'symbol',
    ];

    /**
     * Get all the countries that use this Currency.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function countries()
    {
        return $this->belongsToMany(
            Country::class,
            'country_currency',
            'currency_code',
            'country_code',
            'code',
            'iso3166_alpha2'
        );
    }

    /**
     * Get a currency by its parent country.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $countryCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCountry(Builder $query, string $countryCode)
    {
        return $query->whereHas('countries', function (Builder $query) use ($countryCode) {
            $query->where('iso3166_alpha2', $countryCode);
        });
    }
}
