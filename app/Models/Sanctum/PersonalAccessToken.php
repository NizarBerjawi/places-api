<?php

namespace App\Models\Sanctum;

use DateTimeInterface;
use Illuminate\Support\Str;
use Laravel\Sanctum\NewAccessToken;
use Laravel\Sanctum\PersonalAccessToken as SanctumPersonalAccessToken;

class PersonalAccessToken extends SanctumPersonalAccessToken
{
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
