<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreMapLayerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:map_layers,slug'],
            'type' => ['required', Rule::in(['geojson', 'tiles', 'wms'])],
            'config' => ['nullable', 'array'],
            'style' => ['nullable', 'array'],
            'is_active' => ['boolean'],
            'is_default' => ['boolean'],
            'min_year' => ['nullable', 'integer', 'min:1970', 'max:'.(date('Y') + 1)],
            'max_year' => ['nullable', 'integer', 'min:1970', 'max:'.(date('Y') + 1), 'gte:min_year'],
        ];
    }
}

