<?php

namespace App\Models;

use App\Models\Sanctum\PersonalAccessToken;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    public $fillable = [
        'product_id',
        'session_id',
    ];

    public function token()
    {
        return $this->belongsToOne(PersonalAccessToken::class);
    }
}
