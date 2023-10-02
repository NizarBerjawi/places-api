<?php

namespace App\Validation;

use Carbon\Carbon;
use Carbon\CarbonInterval;
use Illuminate\Validation\Validator;

class ValidateFreeTokenExpiry
{
    /**
     * Validates that the user has not reached the token limit of their
     * subscription,
     *
     * @return void
     */
    public function __invoke(Validator $validator)
    {
        if (! request()->input('expires_at')) {
            $error = __('tokens.validation.expiry.required');
        }

        $expiry = Carbon::make(request()->input('expires_at'));

        $expiryInterval = Carbon::now()->endOfDay()->diff($expiry);
        $allowedInterval = CarbonInterval::week();

        if ($allowedInterval->lt($expiryInterval)) {
            $error = __('tokens.validation.expiry.limit');
        }

        if (! empty($error)) {
            $validator->errors()->add('expires_at', $error);
        }
    }
}
