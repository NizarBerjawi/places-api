<?php

namespace App\Http\Requests;

use App\Validation\ValidateFreeTokenExpiry;
use App\Validation\ValidateTokenLimits;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TokenPostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return ! $this->user()->hasWarning() && $this->user()->subscribed('default');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'token_name' => [
                'required',
                Rule::unique('personal_access_tokens', 'name')->whereNull('deleted_at'),
                'string',
                'max:255',
            ],
            'expires_at' => ['nullable', 'date', 'after_or_equal:tomorrow'],
        ];
    }

    public function after(): array
    {
        $user = request()->user();
        $subscription = $user->subscriptions()->first();

        $isFree = $subscription->tokens_allowed === 1;

        if ($isFree) {
            $after[] = new ValidateFreeTokenExpiry;
        }

        $after[] = new ValidateTokenLimits;

        return $after;
    }
}
