<?php

namespace App\Validation;

use Illuminate\Validation\Validator;

class ValidateTokenLimits
{
    /**
     * Validates that the user has not reached the token limit of their
     * subscription,
     *
     * @return void
     */
    public function __invoke(Validator $validator)
    {
        $user = request()->user();
        $subscription = $user->subscriptions()->first();

        $tokensAllowed = $subscription->tokens_allowed;
        $count = $user->tokens()->count();

        $billing = route('admin.stripe.billing');
        if ($count >= $tokensAllowed) {
            $validator->errors()->add(
                'token_count',
                __('tokens.validation.limit', compact('tokensAllowed', 'billing'))
            );
        }
    }
}
