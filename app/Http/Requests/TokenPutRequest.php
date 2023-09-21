<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TokenPutRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'action' => ['required', Rule::in(['update', 'regenerate'])],
            'expires_at' => ['exclude_unless:action,regenerate', 'nullable', 'date', 'after_or_equal:tomorrow'],
            'token_name' => [
                'exclude_unless:action,update',
                'required',
                Rule::unique('personal_access_tokens', 'name')->ignore($this->uuid, 'uuid'),
                'string',
                'max:255',
            ],
        ];
    }
}
