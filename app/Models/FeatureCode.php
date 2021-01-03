<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeatureCode extends Model
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'code';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'code',
        'short_description',
        'full_description'
    ];
    
    /**
     * Get the feature that this feature code belongs to
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function featureClass()
    {
        return $this->belongsTo(FeatureClass::class, 'feature_class_code', 'code');
    }

    /**
     * Get all the places that belong to this Feature Code
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function places()
    {
        return $this->hasMany(Place::class, 'feature_code', 'code');
    }
}
