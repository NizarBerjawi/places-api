<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Alternate Name.
 *
 * @OA\Schema(
 *      schema="alternateName",
 *      type="object",
 *      title="Alternate Name",
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Sydney",
 *           description="The name of the place."
 *      ),
 *      @OA\Property(
 *           property="isPreferredName",
 *           type="boolean",
 *           example="true",
 *           description="Determines if the alternate name is official/preferred."
 *      ),
 *      @OA\Property(
 *           property="isShortName",
 *           type="boolean",
 *           example="true",
 *           description="Determines if the alternate name is a short name."
 *      ),
 *      @OA\Property(
 *           property="isHistoric",
 *           type="boolean",
 *           example="true",
 *           description="Determines if the alternate name is historic and was used in the past."
 *      ),
 *      @OA\Property(
 *           property="isColloquial",
 *           type="boolean",
 *           example="true",
 *           description="Determines if the alternate name is a colloquial or slang term."
 *      )
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
        'geoname_id', 'language_id', 'name', 'is_preferred_name', 'is_short_name', 'is_historic', 'is_colloquial',
    ];

    /**
     * Get the place that this alternate name belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function place()
    {
        return $this->belongsTo(Place::class, 'geoname_id', 'geoname_id');
    }

    /**
     * Get the language that of this alternate name.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_code', 'iso639_3');
    }

    /**
     * Get Alternate names by language.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param array $languages
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByLanguageCode(Builder $query, ...$languages)
    {
        return $query->whereHas('language', function (Builder $query) use ($languages) {
            $query->whereIn('iso639_1', $languages);
        });
    }

    /**
     * Get alternate name by their parent geoname ID.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param array $languages
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByGeonameId(Builder $query, int $geonameId)
    {
        return $query->where('geoname_id', $geonameId);
    }
}
