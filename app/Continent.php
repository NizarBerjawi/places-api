<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Continent extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'name'
    ];

    /**
     * Get the owning continentable model
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function continentable()
    {
        return $this->morphTo();
    }
}
