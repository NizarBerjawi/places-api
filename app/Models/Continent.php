<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Continent.
 *
 * @OA\Schema(
 *      schema="continent",
 *      type="object",
 *      title="Continent",
 *
 *      @OA\Property(
 *          property="code",
 *          type="string",
 *          example="OC",
 *          description="The two letter continent code"
 *      ),
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Oceania",
 *           description="The name of the continent"
 *      )
 * )
 */
class Continent extends Model
{
    /**
     * The primary key for the model.
     *
     * @OA\Parameter(
     *    parameter="continentCode",
     *    name="continentCode",
     *    in="path",
     *    required=true,
     *    description="The code of the continent",
     *    example="EU",
     *
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
        'code', 'name',
    ];

    /**
     * Get the countries that belong to this continent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function countries()
    {
        return $this->hasMany(Country::class, 'continent_code');
    }

    /**
     * Get the corresponding place data of the continent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function place()
    {
        return $this->hasOne(Place::class, 'geoname_id', 'geoname_id');
    }

    /**
     * Get the geometries of all the countries in the continent.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function geometries()
    {
        return $this->hasManyThrough(
            Geometry::class,
            Country::class,
            'continent_code',
            'country_code',
            null,
            'iso3166_alpha2',
        );
    }

    /**
     * Get the alternate names belonging to this continent.
     *
     * @param  string  $value
     * @return array
     */
    public function alternateNames()
    {
        return $this->hasMany(
            AlternateName::class,
            'geoname_id',
            'geoname_id',
        );
    }

    /**
     * Returns non-existing Continent IDs from an array of IDs.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetMissing(Builder $query, array $ids)
    {
        $params = '('.implode('),(', $ids).')';

        $missingQuery = DB::query()
            ->select('t.geoname_id')
            ->fromRaw("(values $params) as t(geoname_id)")
            ->leftJoin('continents', 't.geoname_id', '=', 'continents.geoname_id')
            ->whereNull('continents.geoname_id')
            ->distinct();

        return $query->setQuery($missingQuery);
    }

    /**
     * Scope continents by continent code.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCode(Builder $query, string $code)
    {
        return $query->where('code', $code);
    }
}
