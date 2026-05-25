<?php

namespace App\Http\Requests\UnitReturn;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'          => ['required', 'integer', 'exists:projects,id'],
            'unit_request_id'     => ['required', 'integer', 'exists:unit_requests,id'],
            'return_date'         => ['required', 'date'],
            'demobilization_date' => ['nullable', 'date', 'after_or_equal:return_date'],
            'notes'               => ['nullable', 'string', 'max:2000'],
            'attachment'          => ['nullable', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'items'               => ['required', 'array', 'min:1'],
            'items.*.original_unit_request_item_id' => ['required', 'integer', 'exists:unit_request_items,id'],
            'items.*.qty'         => ['required', 'numeric', 'min:0.01'],
            'items.*.notes'       => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required'      => 'Pilih proyek terlebih dahulu.',
            'unit_request_id.required' => 'Pilih Unit Request sumber terlebih dahulu.',
            'return_date.required'     => 'Tanggal pengembalian wajib diisi.',
            'demobilization_date.after_or_equal' => 'Tanggal demobilisasi tidak boleh sebelum tanggal pengembalian.',
            'items.required' => 'Minimal pilih 1 unit yang dikembalikan.',
            'items.min'      => 'Minimal pilih 1 unit yang dikembalikan.',
        ];
    }
}
