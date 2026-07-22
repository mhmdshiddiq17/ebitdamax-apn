<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StartTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'started_photo' => ['required', 'image', 'max:3072'],
            'values' => ['nullable', 'array'],
            'values.*' => ['nullable'],
        ];
    }
}
