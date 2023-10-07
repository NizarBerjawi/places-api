<?php

namespace App\Http\Requests;

use App\Validation\ValidateTokenExpiry;
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
            'expires_at' => ['required', 'date', 'after_or_equal:tomorrow'],
        ];
    }

    public function after(): array
    {
        return [
            new ValidateTokenExpiry,
            new ValidateTokenLimits,
        ];
    }
}
