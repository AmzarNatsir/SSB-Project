<?php

namespace App\Http\Requests\UnitReplacement;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitReplacementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'replacement_date' => ['sometimes', 'date'],
            'mobilization_date' => ['nullable', 'date', 'after_or_equal:replacement_date'],
            'cause' => ['sometimes', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'items' => ['sometimes', 'array', 'min:1'],
            'items.*.original_unit_request_item_id' => ['required_with:items', 'integer', 'exists:unit_request_items,id'],
            'items.*.replacement_workshop_unit_id' => ['nullable', 'integer'],
            'items.*.replacement_unit_name' => ['required_with:items', 'string', 'max:255'],
            'items.*.replacement_equipment_code' => ['nullable', 'string', 'max:100'],
            'items.*.replacement_qty' => ['required_with:items', 'numeric', 'min:0.01'],
            'items.*.replacement_duration_days' => ['nullable', 'integer', 'min:1'],
            'items.*.reason' => ['required_with:items', 'string', 'max:1000'],
            'items.*.remarks' => ['nullable', 'string', 'max:500'],
        ];
    }
}
