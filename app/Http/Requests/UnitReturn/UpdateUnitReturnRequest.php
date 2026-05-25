<?php

namespace App\Http\Requests\UnitReturn;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'return_date'         => ['sometimes', 'date'],
            'demobilization_date' => ['nullable', 'date', 'after_or_equal:return_date'],
            'notes'               => ['nullable', 'string', 'max:2000'],
            'attachment'          => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'items'               => ['sometimes', 'array', 'min:1'],
            'items.*.original_unit_request_item_id' => ['required_with:items', 'integer', 'exists:unit_request_items,id'],
            'items.*.qty'         => ['nullable', 'numeric', 'min:0.01'],
            'items.*.notes'       => ['nullable', 'string', 'max:500'],
        ];
    }
}
