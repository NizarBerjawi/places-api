<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureClass extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'code',
        'description'
    ];

    /**
     * Get the feature codes for this feature.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function featureCodes()
    {
        return $this->hasMany(FeatureCode::class);
    }

    /**
     * Get the Places that belong to this feature class
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasManyThrough
     */
    public function places()
    {
        return $this->hasManyThrough(
            Place::class,
            FeatureCode::class,
            'feature_class_id',
            'feature_code',
            null,
            'code'
        );
    }
}
