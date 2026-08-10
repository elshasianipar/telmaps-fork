<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDeforestationRecordRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'region_id' => ['required', 'exists:regions,id'],
            'land_cover_type_id' => ['required', 'exists:land_cover_types,id'],
            'year' => ['required', 'integer', 'min:1970', 'max:'.(date('Y') + 1)],
            'change_type' => ['required', Rule::in(['loss', 'gain', 'stable'])],
            'area_km2' => ['required', 'numeric', 'min:0'],
            'cause' => ['nullable', 'string', 'max:255'],
            'source' => ['nullable', 'string', 'max:255'],
            'geometry' => ['nullable', 'array'],
            'notes' => ['nullable', 'string'],
        ];
    }
}

