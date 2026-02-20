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
            'request_date'      => ['required', 'date'],
            'mobilization_date' => ['required', 'date', 'after_or_equal:request_date'],
            'notes'             => ['nullable', 'string', 'max:2000'],
            'attachment'        => ['nullable', 'file', 'mimes:pdf,docx,doc', 'max:10240'], // 10MB
        ];
    }

    public function messages(): array
    {
        return [
            'project_id.required'        => 'Please select a project.',
            'project_id.exists'          => 'Selected project is invalid.',
            'request_date.required'      => 'Request date is required.',
            'mobilization_date.required' => 'Mobilization date is required.',
            'mobilization_date.after_or_equal' => 'Mobilization date must be on or after the request date.',
            'attachment.mimes'           => 'Attachment must be a PDF or DOCX file.',
            'attachment.max'             => 'Attachment must not exceed 10MB.',
        ];
    }
}
