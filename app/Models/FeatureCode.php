<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Feature Code.
 *
 * @OA\Schema(
 *      schema="featureCode",
 *      type="object",
 *      title="Feature Code"
 * )
 * @OA\Property(
 *      property="code",
 *      type="string",
 *      example="ADM4H",
 *      description="The code of the feature code"
 * )
 * @OA\Property(
 *      property="fullDescription",
 *      type="string",
 *      example="A former fourth-order administrative division",
 *      description="The full description of the feature code"
 * )
 * @OA\Property(
 *      property="shortDescription",
 *      type="string",
 *      example="Historical fourth-order administrative division",
 *      description="The short description of the feature code"
 * )
 */
class FeatureCode extends Model
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
    public $fillable = [
        'code',
        'short_description',
        'full_description',
    ];

    /**
     * Get the feature that this feature code belongs to.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function featureClass()
    {
        return $this->belongsTo(FeatureClass::class, 'feature_class_code', 'code');
    }

    /**
     * Get all the places that belong to this Feature Code.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function places()
    {
        return $this->hasMany(Place::class, 'feature_code', 'code');
    }

    public function scopeByFeatureCodeCode(Builder $query, $featureCodeCode)
    {
        return $query->where('code', $featureCodeCode);
    }
}
