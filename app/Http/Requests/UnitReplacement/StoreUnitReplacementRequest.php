<?php

namespace App\Http\Requests\UnitReplacement;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitReplacementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'unit_request_id' => ['required', 'integer', 'exists:unit_requests,id'],
            'replacement_date' => ['required', 'date'],
            'mobilization_date' => ['nullable', 'date', 'after_or_equal:replacement_date'],
            'cause' => ['required', 'string', 'max:2000'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'attachment' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:10240'],
            'items' => ['required', 'array', 'min:1'],
            'items.*.original_unit_request_item_id' => ['required', 'integer', 'exists:unit_request_items,id'],
            'items.*.replacement_workshop_unit_id' => ['nullable', 'integer'],
            'items.*.replacement_unit_name' => ['required', 'string', 'max:255'],
            'items.*.replacement_equipment_code' => ['nullable', 'string', 'max:100'],
            'items.*.replacement_qty' => ['required', 'numeric', 'min:0.01'],
            'items.*.replacement_duration_days' => ['nullable', 'integer', 'min:1'],
            'items.*.reason' => ['required', 'string', 'max:1000'],
            'items.*.remarks' => ['nullable', 'string', 'max:500'],
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required' => 'Pilih proyek terlebih dahulu.',
            'unit_request_id.required' => 'Pilih Unit Request sumber terlebih dahulu.',
            'replacement_date.required' => 'Tanggal penggantian wajib diisi.',
            'mobilization_date.after_or_equal' => 'Tanggal mobilisasi tidak boleh sebelum tanggal penggantian.',
            'cause.required' => 'Penyebab penggantian unit wajib diisi.',
            'items.required' => 'Minimal pilih 1 unit pengganti.',
            'items.min' => 'Minimal pilih 1 unit pengganti.',
        ];
    }
}
