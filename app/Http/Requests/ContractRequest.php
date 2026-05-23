<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ContractRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'project_id'     => 'required|exists:projects,id',
            'negotiation_id' => 'required|exists:negotiations,id',
            'start_date'     => 'required|date',
            'end_date'       => 'required|date|after_or_equal:start_date',
            'attachment'     => 'nullable|file|mimes:pdf,doc,docx|max:10240', // 10MB
        ];
    }

    public function messages(): array
    {
        return [
            'negotiation_id.required' => 'Pilih negosiasi yang akan dijadikan kontrak.',
            'negotiation_id.exists'   => 'Negosiasi yang dipilih tidak valid.',
        ];
    }
}
