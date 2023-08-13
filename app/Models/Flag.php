<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Flag.
 *
 * @OA\Schema(
 *      schema="flag",
 *      type="object",
 *      title="Flag",
 *      description="A flag is a piece of fabric with a distinctive design and colours. It is used as a symbol, a signalling device, or for decoration.",
 * 
 *      @OA\Property(
 *           property="countryCode",
 *           type="string",
 *           example="AU",
 *           description="The two-letter ISO 3166-1 alpha-2 country code that this flag belongs to"
 *      ),
 *      @OA\Property(
 *           property="url",
 *           type="string",
 *           example="http://localhost:8080/storage/flags/AU.gif",
 *           description="The location of the flag image"
 *      ),
 *      @OA\Property(
 *           property="filename",
 *           type="string",
 *           example="AU.gif",
 *           description="The name of the flag file"
 *      ),
 * )
 */
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
        'filepath', 'filename', 'extension',
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
     * @return \Illuminate\Database\Eloquent\Builder $query
     */
    public function scopeByCountryCode(Builder $query, string $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }
}
