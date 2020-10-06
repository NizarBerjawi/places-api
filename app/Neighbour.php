<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Neighbour extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'countries';

    /**
     * Returns the country this neighbour belongs to
     * 
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function country()
    {
        return $this->belongsToMany(Country::class);
    }
}
