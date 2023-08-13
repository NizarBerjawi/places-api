<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Feature Class.
 *
 * @OA\Schema(
 *      schema="featureClass",
 *      type="object",
 *      title="Feature Class",
 *      description="Feature Classes are high-level categories used to categorize geographical names. There are a total of 9 Feature Classes.",
 *
 *      @OA\Property(
 *           property="code",
 *           type="string",
 *           example="A",
 *           description="The code of the feature class",
 *           enum={"A", "H", "L", "P", "R", "S", "T", "U", "V"}
 *      ),
 *      @OA\Property(
 *           property="description",
 *           type="string",
 *           example="Country, state, region,...",
 *           description="The description of the feature class"
 *      )
 * )
 */
class FeatureClass extends Model
{
    /**
     * The primary key for the model.
     *
     * @OA\Parameter(
     *    parameter="featureClassCode",
     *    name="featureClassCode",
     *    in="path",
     *    required=true,
     *    description="The code of the Feature Class",
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
    public $fillable = [
        'code',
        'description',
    ];

    /**
     * Get the feature codes for this feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function featureCodes()
    {
        return $this->hasMany(FeatureCode::class, 'feature_class_code', 'code');
    }

    /**
     * Get the Places that belong to this feature class.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function places()
    {
        return $this->hasManyThrough(
            Place::class,
            FeatureCode::class,
            'feature_class_code',
            'feature_code',
            'code'
        );
    }

    /**
     * Get a feature class by feature class code.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByFeatureClassCode(Builder $query, string $featureClassCode)
    {
        return $query->where('code', $featureClassCode);
    }

    public function __toString()
    {
        return $this->code.': '.$this->description;
    }
}
