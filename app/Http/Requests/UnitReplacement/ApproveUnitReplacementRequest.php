<?php

namespace App\Http\Requests\UnitReplacement;

use Illuminate\Foundation\Http\FormRequest;

class ApproveUnitReplacementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', 'string', 'in:approved,rejected'],
            'remarks' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
