<?php

namespace App\Http\Requests\UnitRequest;

use Illuminate\Foundation\Http\FormRequest;

class ApproveUnitRequestRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', 'string', 'in:approved,rejected'],
            'remarks'  => ['nullable', 'string', 'max:1000'],
        ];
    }

    public function messages(): array
    {
        return [
            'decision.required' => 'A decision (approved or rejected) is required.',
            'decision.in'       => 'Decision must be either approved or rejected.',
        ];
    }
}
