<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'iso639_1',
        'iso639_2',
        'iso639_3',
        'name',
    ];

    /**
     * Get all the Countries that are associated with this language.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function countries()
    {
        return $this->belongsToMany(Country::class, null, null, 'country_code');
    }

    /**
     * Get languages have belonging to specific countries
     *
     * @param string $countryCode
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder  $query
     */
    public function scopeByCountry(Builder $query, string $countryCode)
    {
        return $query
            ->whereHas('countries', function (Builder $query) use ($countryCode) {
                $query->where('iso3166_alpha2', $countryCode);
            });
    }
}
