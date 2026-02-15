<?php

namespace App\Http\Requests\Budget;

use App\Enums\BudgetCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Authorized via Policy/Gate later
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'exists:projects,id'],
            'profit_margin_percent' => ['required', 'numeric', 'min:0', 'max:100'],
            'items' => ['array'],
            'items.*.category' => ['required', Rule::enum(BudgetCategory::class)],
            'items.*.item_name' => ['required', 'string', 'max:255'],
            'items.*.qty' => ['required', 'numeric', 'min:0'],
            'items.*.units' => ['nullable', 'string', 'max:50'],
            'items.*.unit_cost' => ['required', 'numeric', 'min:0'],
            'items.*.description' => ['nullable', 'string'],
        ];
    }
}
