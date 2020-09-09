<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'latitude', 'longitude'
    ];
    
    /**
     * Get the owning locationable model
     * 
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function locationable()
    {
        return $this->morphTo();
    }
}
