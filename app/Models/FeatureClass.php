<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Feature Class.
 *
 * @OA\Schema(
 *      schema="feature_class",
 *      type="object",
 *      title="Feature Class"
 * )
 * @OA\Property(
 *      property="name",
 *      type="string",
 *      example="A",
 *      description="The name of the feature class"
 * )
 * @OA\Property(
 *      property="description",
 *      type="string",
 *      example="Country, state, region,...",
 *      description="The description of the feature class"
 * )
 */
class FeatureClass extends Model
{
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
}
