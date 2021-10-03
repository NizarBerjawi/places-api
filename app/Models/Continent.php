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
class Continent extends Model
{
    /**
     * The primary key for the model.
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
