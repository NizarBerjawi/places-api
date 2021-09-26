<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="continent",
 *      type="object",
 *      title="Continent"
 * )
 *
 * @OA\Property(
 *      property="code",
 *      type="string",
 *      example="OC",
 *      description="The two letter continent code"
 * )
 *
 * @OA\Property(
 *      property="name",
 *      type="string",
 *      example="Oceania",
 *      description="The name of the continent"
 * )
 */
class AlternateName extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'geoname_id', 'language_id', 'name', 'is_preferred_name', 'is_short_name',
    ];

    /**
     * Get the countries that belong to this continent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function place()
    {
        return $this->belongsTo(Place::class);
    }

    /**
     * Get the language that of this alternate name.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class);
    }

    /**
     * Get Alternate names by language.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param array $languages
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLanguage(Builder $query, array $languages)
    {
        return $query->whereHas('language', function (Builder $query) use ($languages) {
            $query->whereIn('iso639_1', $languages);
        });
    }
}
