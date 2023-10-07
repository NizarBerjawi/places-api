<?php

namespace App\Models\Sanctum;

use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Laravel\Cashier\Subscription;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
    use SoftDeletes;

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

    public function subscription()
    {
        return $this->hasOneThrough(
            Subscription::class,
            User::class,
            'id',
            'user_id',
            'tokenable_id'
        );
    }

    /**
     * Regenerates the current access token.
     *
     * @return \Laravel\Sanctum\NewAccessToken
     */
    public function regenerate($options = [])
    {
        $this->update([
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
        ] + $options);

        return new NewAccessToken($this, $this->getKey().'|'.$plainTextToken);
    }

    /**
     * Determines if a Token is active or not
     */
    public function active(): bool
    {
        return ! $this->trashed() && ($this->forever() || ! $this->expired());
    }

    /**
     * Determines if a Token is expired or not
     */
    public function expired(): bool
    {
        return $this->isExpirable() && $this->expires_at->isBefore(now());
    }

    /**
     * Determines if a Token is lasts forever or not
     */
    public function forever()
    {
        return ! $this->isExpirable();
    }

    /**
     * Determines if a Token has an expiry date
     */
    public function isExpirable()
    {
        return ! is_null($this->expires_at);
    }

    /**
     * Scope a query to only include a token model matching the
     * provided token
     *
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $builder
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeByToken(Builder $query, string $token)
    {
        if (strpos($token, '|') === false) {
            return $query->where('token', hash('sha256', $token));
        }
    }

    public static function minExpiry()
    {
        return Carbon::now()->tomorrow();
    }

    public static function maxExpiry(Subscription $subscription)
    {
        $interval = CarbonInterval::create($subscription->expiry_period);

        if ($subscription->is_free) {
            $days = $interval->totalDays;

            return Carbon::now()->endOfDay()->addDays($days);
        }

        $years = $interval->totalYears;

        return Carbon::now()->endOfDay()->addYears($years);
    }
}
