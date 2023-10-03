<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Place.
 *
 * @OA\Schema(
 *      schema="place",
 *      type="object",
 *      title="Place",
 *      description="The place object represents any geographic place within a country. This could be the capital, a mountain, a road, or even a building.",
 *
 *      @OA\Property(
 *           property="geonameId",
 *           type="integer",
 *           example="105480",
 *           description="The Geoname ID of a certain place"
 *      ),
 *      @OA\Property(
 *           property="name",
 *           type="string",
 *           example="Jāl Jahlān",
 *           description="The name of a place"
 *      ),
 *      @OA\Property(
 *           property="asciiName",
 *           type="string",
 *           example="Jal Jahlan",
 *           description="The ASCII name of a place"
 *      ),
 *      @OA\Property(
 *           property="population",
 *           type="integer",
 *           example="0",
 *           description="The population of a certain place"
 *      ),
 *      @OA\Property(
 *           property="elevation",
 *           type="integer",
 *           example="0",
 *           description="The elevation of a place in meters"
 *      ),
 *      @OA\Property(
 *           property="dem",
 *           type="integer",
 *           example="79",
 *           description="The digital elevation model of a place in meters"
 *      ),
 * )
 */
class Place extends Model
{
    /**
     * The primary key for the model.
     *
     * @OA\Parameter(
     *    parameter="geonameId",
     *    name="geonameId",
     *    in="path",
     *    required=true,
     *    description="The Geoname ID of the place",
     *
     *    @OA\Schema(
     *        type="string"
     *    )
     * )
     *
     * @var string
     */
    protected $primaryKey = 'geoname_id';

    /**
     * The "type" of the primary key geoname_id.
     *
     * @var string
     */
    protected $keyType = 'integer';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'population', 'elevation',
    ];

    /**
     * Get the Feature Code that this Place belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function featureCode()
    {
        return $this->belongsTo(FeatureCode::class, 'feature_code', 'code');
    }

    /**
     * Get the Feature Class that this place belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function featureClass()
    {
        return $this->belongsToMany(
            FeatureClass::class,
            'feature_codes',
            'code',
            'feature_class_code',
            'feature_code',
            'code'
        );
    }

    /**
     * Get the Time Zone that this Place belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function timeZone()
    {
        return $this->belongsTo(TimeZone::class, 'time_zone_code', 'code');
    }

    /**
     * Get the Country that this Place belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_code', 'iso3166_alpha2');
    }

    /**
     * Get the Location of this Place.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function location()
    {
        return $this->hasOne(Location::class, 'geoname_id');
    }

    /**
     * Get the alternate names belonging to this place.
     *
     * @param  string  $value
     * @return array
     */
    public function alternateNames()
    {
        return $this->hasMany(AlternateName::class, 'geoname_id');
    }

    /**
     * Returns non-existing Place IDs from an array of IDs.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeGetMissing(Builder $query, array $ids)
    {
        $params = '('.implode('),(', $ids).')';

        $missingQuery = DB::query()
            ->select('t.geoname_id')
            ->fromRaw("(values $params) as t(geoname_id)")
            ->leftJoin('places', 't.geoname_id', '=', 'places.geoname_id')
            ->whereNull('places.geoname_id')
            ->distinct();

        return $query->setQuery($missingQuery);
    }

    /**
     * Get places scoped by geoname id.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByGeonameId(Builder $query, int $geonameId)
    {
        return $query->where('geoname_id', $geonameId);
    }

    /**
     * Get places scoped by country.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCountry(Builder $query, string $countryCode)
    {
        return $query->where('country_code', $countryCode);
    }

    /**
     * Get places scoped by cities.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByCities(Builder $query)
    {
        return $query->whereHas('featureClass', function (Builder $query) {
            $query->where('feature_classes.code', 'P');
        });
    }
}
