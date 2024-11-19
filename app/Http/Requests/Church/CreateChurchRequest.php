<?php

namespace App\Http\Requests\Church;

use Illuminate\Foundation\Http\FormRequest;

class CreateChurchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'abbreviation' => 'nullable|string|max:255',
            'email' => 'required|string|email|max:255|unique:churches',
            'phone' => 'nullable|string|max:255|unique:churches',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'country' => 'nullable|string|max:255',
            'logo'=>'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ];
    }
}