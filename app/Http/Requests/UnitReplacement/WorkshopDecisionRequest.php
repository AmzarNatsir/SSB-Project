<?php

namespace App\Http\Requests\UnitReplacement;

use Illuminate\Foundation\Http\FormRequest;

class WorkshopDecisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', 'string', 'in:approved,rejected'],
            'notes' => ['nullable', 'string', 'max:2000'],
            'items' => ['sometimes', 'array'],
            'items.*.id' => ['required_with:items', 'integer'],
            'items.*.unit_ready' => ['nullable', 'boolean'],
            'items.*.operator_id' => ['nullable', 'integer'],
            'items.*.operator_name' => ['nullable', 'string', 'max:200'],
            'items.*.remarks' => ['nullable', 'string', 'max:500'],
        ];
    }
}
