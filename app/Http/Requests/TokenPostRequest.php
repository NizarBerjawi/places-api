<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class TokenPostRequest extends FormRequest
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
            'token_name' => [
                'required',
                'unique:personal_access_tokens,name',
                'string',
                'max:255',
            ],
            'product_id' => ['required', 'string', 'max:255'],
        ];
    }

    public function after(): array
    {

        return [
            function (Validator $validator) {
                $count = $this->user()->tokens()->count();

                if ($count === 3) {
                    $validator->errors()->add(
                        'token_count',
                        '<span class="has-text-weight-bold">Token limit reached.</span> Your account can only have up to 3 tokens.'
                    );
                }
            },
        ];
    }
}
