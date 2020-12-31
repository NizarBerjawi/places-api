<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'code', 'symbol'
    ];
    
    /**
     * Get all the countries that use this Currency
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
}
