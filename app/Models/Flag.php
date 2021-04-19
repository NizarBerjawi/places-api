<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Flag extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'country_code';

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
        'path',
    ];

    /**
     * Get the country that this flag belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code');
    }

    /**
     * Get a Flag by country code.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  string $countryCode
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeByCountry(Builder $query, string $countryCode)
    {
        return $query->whereHas('country', function (Builder $query) use ($countryCode) {
            return $query->where('country_code', $countryCode);
        });
    }
}
