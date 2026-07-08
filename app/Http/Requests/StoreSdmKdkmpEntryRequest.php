<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreSdmKdkmpEntryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $entryId = $this->route('sdm_data')?->id;

        return [
            'nama_koperasi' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sdm_kdkmp_entries', 'nama_koperasi')->ignore($entryId),
            ],
            'jumlah_karyawan' => ['required', 'integer', 'min:0'],
            'catatan' => ['nullable', 'string'],
        ];
    }
}
