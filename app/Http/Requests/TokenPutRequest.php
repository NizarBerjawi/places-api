<?php

namespace App\Http\Requests;

use App\Validation\ValidateFreeTokenExpiry;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class TokenPutRequest extends FormRequest
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
            'action' => ['required', Rule::in(['update', 'regenerate'])],
            'expires_at' => ['exclude_unless:action,regenerate', 'nullable', 'date', 'after_or_equal:tomorrow'],
            'token_name' => [
                'exclude_unless:action,update',
                'required',
                Rule::unique('personal_access_tokens', 'name')->ignore($this->uuid, 'uuid')->whereNull('deleted_at'),
                'string',
                'max:255',
            ],
        ];
    }

    public function after(): array
    {
        if ($this->get('action') !== 'regenerate') {
            return [];
        }

        $after = [];
        $user = request()->user();
        $subscription = $user->subscriptions()->first();

        $isFree = $subscription->tokens_allowed === 1;

        if ($isFree) {
            $after[] = new ValidateFreeTokenExpiry;
        }

        return $after;
    }
}
