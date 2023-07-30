<?php

namespace App\Models\Sanctum;

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
    public function regenerateToken()
    {
        $this->update([
            'token' => hash('sha256', $plainTextToken = Str::random(40)),
        ]);

        return new NewAccessToken($this, $this->getKey().'|'.$plainTextToken);
    }
}
