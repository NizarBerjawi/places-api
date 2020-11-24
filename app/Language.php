<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'iso639_1',
        'iso639_2',
        'iso639_3',
        'language_name',
    ];
}
