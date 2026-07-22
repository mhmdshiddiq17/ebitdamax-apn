<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTaskCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $taskCategoryId = $this->route('task_category')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('task_categories', 'name')->ignore($taskCategoryId),
            ],
            'description' => ['nullable', 'string'],
        ];
    }
}
