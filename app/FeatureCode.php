<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FeatureCode extends Model
{
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
    public function feature()
    {
        return $this->belongsTo(Feature::class);
    }
}
