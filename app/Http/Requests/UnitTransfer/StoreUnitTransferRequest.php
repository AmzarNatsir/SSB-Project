<?php

namespace App\Http\Requests\UnitTransfer;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitTransferRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'source_project_id'      => ['required', 'integer', 'exists:projects,id'],
            'source_unit_request_id' => ['required', 'integer', 'exists:unit_requests,id'],
            'destination_project_id' => ['required', 'integer', 'different:source_project_id', 'exists:projects,id'],
            'transfer_date'          => ['required', 'date'],
            'notes'                  => ['nullable', 'string', 'max:2000'],
            'attachment'             => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'items'                  => ['required', 'array', 'min:1'],
            'items.*.original_unit_request_item_id' => ['required', 'integer', 'exists:unit_request_items,id'],
            'items.*.qty'            => ['required', 'numeric', 'min:0.01'],
            'items.*.notes'          => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'source_project_id.required'      => 'Pilih project asal terlebih dahulu.',
            'source_unit_request_id.required' => 'Pilih Unit Request sumber terlebih dahulu.',
            'destination_project_id.required' => 'Pilih project tujuan.',
            'destination_project_id.different'=> 'Project tujuan harus berbeda dengan project asal.',
            'transfer_date.required'          => 'Tanggal transfer wajib diisi.',
            'items.required' => 'Minimal pilih 1 unit yang akan ditransfer.',
            'items.min'      => 'Minimal pilih 1 unit yang akan ditransfer.',
        ];
    }
}
