<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrganizationCalculationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_id' => ['required', 'exists:organizations,id'],
            'classification' => ['nullable', 'string', 'max:255'],

            'man_cost' => ['required', 'numeric', 'min:0'],
            'method_cost' => ['required', 'numeric', 'min:0'],
            'material_cost' => ['required', 'numeric', 'min:0'],
            'machine_cost' => ['required', 'numeric', 'min:0'],

            'doc_variable' => ['required', 'numeric', 'min:0'],
            'doc_fixed' => ['required', 'numeric', 'min:0'],
            'ioc' => ['required', 'numeric', 'min:0'],

            'source_sheet' => ['nullable', 'string', 'max:255'],
        ];
    }
}
