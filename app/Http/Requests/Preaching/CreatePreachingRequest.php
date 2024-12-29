<?php

namespace App\Http\Requests\Preaching;

use Illuminate\Foundation\Http\FormRequest;

class CreatePreachingRequest extends FormRequest
{
    /**
     * @return array{title: string, description: string, audio_url: string, preacher: string}
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'description' => 'nullable|string',
            'preacher' => 'required|string',
            'audio_url' => 'string|required',
            'cover_url' => 'required|string',
            'color' => 'required|string',
        ];
    }

    /**
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }
}
