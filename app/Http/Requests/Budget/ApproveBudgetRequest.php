<?php

namespace App\Http\Requests\Budget;

use App\Enums\ApprovalDecision;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ApproveBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'decision' => ['required', Rule::enum(ApprovalDecision::class)],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
