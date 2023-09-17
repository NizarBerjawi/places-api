<?php

namespace App\Models\Sanctum;

use App\Models\Scopes\PaidTokenScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'uuid';

    /**
     * The "type" of the primary key ID.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'token',
        'abilities',
        'expires_at',
        'is_paid',
    ];

    /**
     * Bootstrap the model and its traits.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function (Model $model) {
            if (empty($model->{$model->getKeyName()})) {
                $model->{$model->getKeyName()} = Str::uuid()->toString();
            }
        });
    }

    /**
     * The "booted" method of the model.
     */
    protected static function booted(): void
    {
        // static::addGlobalScope(new PaidTokenScope);
    }

    /**
     * Regenerates the current access token.
     *
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function regenerate()
    {
        $this->update([
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
        ]);

        return new NewAccessToken($this, $this->getKey().'|'.$plainTextToken);
    }

    /**
     * Activates the current access token when payment is successful.
     *
     * @return bool
     */
    public function pay()
    {
        $this->update([
            'is_paid' => true,
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
        ]);

        return new NewAccessToken($this, $this->getKey().'|'.$plainTextToken);
    }
}
