<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FinishTaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'finished_photo' => ['required', 'image', 'max:3072'],
            'values' => ['nullable', 'array'],
            'values.*' => ['nullable'],
        ];
    }
}
