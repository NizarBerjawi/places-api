<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Currency.
 *
 * @OA\Schema(
 *      schema="currency",
 *      type="object",
 *      title="Currency",
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Dollar",
 *           description="The name of the currency"
 *      ),
 *      @OA\Property(
 *           property="code",
 *           type="string",
 *           example="AUD",
 *           description="The code of the currency"
 *      )
 * )
 */
class Currency extends Model
{
    /**
     * The primary key for the model.
     *
     * @OA\Parameter(
     *    parameter="currencyCode",
     *    name="currencyCode",
     *    in="path",
     *    required=true,
     *    description="The ISO 4217 code of the currency",
     *    @OA\Schema(
     *        type="string"
     *    )
     * )
     *
     * @var string
     */
    protected $primaryKey = 'code';

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

    /**
     * Get a currency by its currency code.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $currencyCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCurrencyCode(Builder $query, string $currencyCode)
    {
        return $query->where('code', $currencyCode);
    }
}
