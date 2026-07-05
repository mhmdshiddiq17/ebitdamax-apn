<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_id' => ['required', 'exists:organizations,id'],
            'job_description' => ['nullable', 'string'],
            'qualification' => ['nullable', 'string'],
            'value_chain' => ['nullable', 'string'],
            'method_cost' => ['nullable', 'numeric', 'min:0'],
            'source_sheet' => ['nullable', 'string', 'max:255'],
        ];
    }
}
