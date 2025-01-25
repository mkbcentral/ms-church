<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;

class FacebookUserRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string'],
            'email' => ['required', 'email'],
            'role_id' => ['required', 'numeric'],
            'fbk_avatar_url' => ['nullable', 'string'],
        ];
    }
}
