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
            'description' => 'required|string',
            'audio_url' => 'nullable',
            'preacher'=>'required|string',
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
