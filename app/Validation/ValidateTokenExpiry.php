<?php

namespace App\Validation;

use App\Models\Sanctum\PersonalAccessToken;
use Carbon\Carbon;
use Illuminate\Validation\Validator;

class ValidateTokenExpiry
{
    /**
     * Validates that the user has not reached the token limit of their
     * subscription,
     *
     * @return void
     */
    public function __invoke(Validator $validator)
    {
        $subscription = request()->user()->subscriptions()->first();

        $expiry = Carbon::make(request()->input('expires_at'));

        $allowedExpiry = PersonalAccessToken::maxExpiry($subscription);

        if ($allowedExpiry->gt($expiry)) {
            return;
        }

        $validator
            ->errors()
            ->add('expires_at', __('tokens.validation.expiry.limit', ['expiryAllowed' => $allowedExpiry->diffForHumans()]));
    }
}
