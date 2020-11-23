<?php

namespace App;

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
}
