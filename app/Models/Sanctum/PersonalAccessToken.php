<?php

namespace App\Models\Sanctum;

use DateTimeInterface;
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
     * Regenerates the current access token.
     *
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function regenerateToken(DateTimeInterface $expiresAt = null)
    {
        $this->update([
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
            'expires_at' => $expiresAt,
        ]);

        return new NewAccessToken($this, $this->getKey().'|'.$plainTextToken);
    }
}
