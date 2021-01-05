<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TimeZone extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'gmt_offset'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'gmt_offset' => 'float'
    ];
}
