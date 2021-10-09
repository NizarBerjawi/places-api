<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *      schema="continent",
 *      type="object",
 *      title="Continent",
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
     * Get the alternate names belonging to this continent.
     *
     * @param string $value
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
     * Get a continent scoped by continent code.
     *
     * @param \Illuminate\Database\Eloquent\Builder  $query
     * @param string $continentCode
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByContinentCode(Builder $query, $continentCode)
    {
        return $query->where('code', $continentCode);
    }
}
