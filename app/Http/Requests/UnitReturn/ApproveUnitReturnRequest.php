<?php

namespace App\Http\Requests\UnitReturn;

use Illuminate\Foundation\Http\FormRequest;

class ApproveUnitReturnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', 'in:approved,rejected'],
            'remarks'  => ['nullable', 'string', 'max:500'],
        ];
    }
}
