<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Language.
 *
 * @OA\Schema(
 *      schema="language",
 *      type="object",
 *      title="Language"
 * )
 * @OA\Property(
 *      property="name",
 *      type="string",
 *      example="English",
 *      description="The name of a specific language"
 * )
 * @OA\Property(
 *      property="iso639_1",
 *      type="string",
 *      example="en",
 *      description="Two-letter language codes, one per language for ISO 639 macrolanguage"
 * )
 * @OA\Property(
 *      property="iso639_2",
 *      type="string",
 *      example="eng",
 *      description="Three-letter language codes but with some codes derived from English names rather than native names of languages"
 * )
 * @OA\Property(
 *      property="iso639_3",
 *      type="string",
 *      example="eng",
 *      description="Three-letter language codes but with distinct codes for each variety of an ISO 639 macrolanguage"
 * )
 */
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
     * Get languages by country code.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $countryCode
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
