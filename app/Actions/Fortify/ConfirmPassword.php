<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Fortify;

class ConfirmPassword
{
    /**
     * Confirm that the given password is valid for the given user.
     *
     * @param  \Illuminate\Contracts\Auth\StatefulGuard  $guard
     * @param  mixed  $user
     * @return bool
     */
    public function __invoke(User $user, string $password = null)
    {
        $username = Fortify::username();

        return Validator::make([
            $username => $user->{$username},
            'password' => $password,
        ], [
            'password' => ['current_password'],
        ])->validateWithBag('confirmPassword');
    }
}
