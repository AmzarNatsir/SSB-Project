<?php

namespace App\Http\Requests\UnitRequest;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUnitRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'request_date'      => ['sometimes', 'date'],
            'mobilization_date' => ['sometimes', 'date', 'after_or_equal:request_date'],
            'notes'             => ['nullable', 'string', 'max:2000'],
            'attachment'        => ['nullable', 'file', 'mimes:pdf,docx,doc', 'max:10240'],
            'items'             => ['sometimes', 'array'],
            'items.*.id'        => ['sometimes', 'integer'],
            'items.*.remarks'   => ['nullable', 'string', 'max:500'],
            'items.*.duration_days' => ['nullable', 'integer', 'min:1'],
        ];
    }

    public function messages(): array
    {
        return [
            'mobilization_date.after_or_equal' => 'Mobilization date must be on or after the request date.',
            'attachment.mimes'                 => 'Attachment must be a PDF or DOCX file.',
            'attachment.max'                   => 'Attachment must not exceed 10MB.',
        ];
    }
}
