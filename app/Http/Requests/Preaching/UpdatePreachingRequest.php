<?php

namespace App\Http\Requests\Preaching;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePreachingRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'cover_url' => 'nullable|string',
            'audio_url' => 'nullable|string',
            'color' => 'nullable|string',
            'preacher' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }
}
