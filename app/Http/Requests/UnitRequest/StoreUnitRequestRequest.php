<?php

namespace App\Http\Requests\UnitRequest;

use Illuminate\Foundation\Http\FormRequest;

class StoreUnitRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'        => ['required', 'integer', 'exists:projects,id'],
            'contract_id'       => ['required', 'integer', 'exists:contracts,id'],
            'request_date'      => ['required', 'date'],
            'mobilization_date' => ['required', 'date', 'after_or_equal:request_date'],
            'notes'             => ['nullable', 'string', 'max:2000'],
            'attachment'        => ['nullable', 'file', 'mimes:pdf,docx,doc', 'max:10240'], // 10MB
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required'        => 'Pilih proyek terlebih dahulu.',
            'project_id.exists'          => 'Proyek yang dipilih tidak valid.',
            'contract_id.required'       => 'Pilih Final Contract terlebih dahulu.',
            'contract_id.exists'          => 'Kontrak yang dipilih tidak valid.',
            'request_date.required'      => 'Tanggal permintaan wajib diisi.',
            'mobilization_date.required' => 'Tanggal mobilisasi wajib diisi.',
            'mobilization_date.after_or_equal' => 'Tanggal mobilisasi tidak boleh sebelum tanggal permintaan.',
            'attachment.mimes'           => 'Lampiran harus berformat PDF / DOC / DOCX.',
            'attachment.max'             => 'Lampiran tidak boleh lebih dari 10MB.',
        ];
    }
}
