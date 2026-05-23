<?php

namespace App\Http\Controllers;

use App\Models\PettyCashExpenseCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class PettyCashExpenseCategoryController extends Controller
{
    public function index(Request $request)
    {
        $query = PettyCashExpenseCategory::query()->latest();

        if ($search = $request->string('q')->toString()) {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'like', "%{$search}%")
                  ->orWhere('name', 'like', "%{$search}%");
            });
        }

        if ($request->filled('is_active')) {
            $query->where('is_active', $request->boolean('is_active'));
        }

        $categories = $query->paginate(15)->withQueryString();

        return view('petty-cash-categories.index', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'code' => 'required|string|max:30|unique:petty_cash_expense_categories,code',
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', true);

        PettyCashExpenseCategory::create($data);

        return redirect()->route('petty-cash-categories.index')
            ->with('success', "Jenis Biaya {$data['code']} berhasil dibuat.");
    }

    public function update(Request $request, PettyCashExpenseCategory $pettyCashCategory)
    {
        $data = $request->validate([
            'code' => ['required', 'string', 'max:30', Rule::unique('petty_cash_expense_categories', 'code')->ignore($pettyCashCategory->id)],
            'name' => 'required|string|max:150',
            'description' => 'nullable|string|max:1000',
            'is_active' => 'nullable|boolean',
        ]);
        $data['is_active'] = $request->boolean('is_active', false);

        $pettyCashCategory->update($data);

        return redirect()->route('petty-cash-categories.index')
            ->with('success', 'Jenis Biaya berhasil diperbarui.');
    }

    public function destroy(PettyCashExpenseCategory $pettyCashCategory)
    {
        $pettyCashCategory->delete();
        return redirect()->route('petty-cash-categories.index')
            ->with('success', 'Jenis Biaya dihapus.');
    }
}
