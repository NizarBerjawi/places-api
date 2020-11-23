<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
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
        'continent_id'
    ];

    /**
     * Get the continent that owns this country
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function continent()
    {
        return $this->belongsTo(Continent::class);
    }

    /**
     * Get all the neighbouring countries of this country
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function neighbours()
    {
        return $this->belongsToMany(Country::class, 'country_neighbour', 'neighbour_id', 'country_id');
    }
}
