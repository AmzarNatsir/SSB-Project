<?php

namespace App\Http\Requests\UnitTransfer;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'destination_project_id' => ['sometimes', 'integer', 'exists:projects,id'],
            'transfer_date'          => ['sometimes', 'date'],
            'notes'                  => ['nullable', 'string', 'max:2000'],
            'attachment'             => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'items'                  => ['sometimes', 'array', 'min:1'],
            'items.*.original_unit_request_item_id' => ['required_with:items', 'integer', 'exists:unit_request_items,id'],
            'items.*.qty'            => ['required_with:items', 'numeric', 'min:0.01'],
            'items.*.notes'          => ['nullable', 'string', 'max:500'],
        ];
    }
}
