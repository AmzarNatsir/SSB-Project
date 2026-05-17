{{--
    One row for unit item table. Required vars: $index (int|'__INDEX__'), $item (UnitFormationItem|null)
--}}
<tr>
    <td>
        <select name="items[{{ $index }}][equipment_unit_id]" class="form-select js-unit-select" required>
            @if($item)
                <option value="{{ $item->equipment_unit_id }}" selected>
                    {{ $item->unit_name }}@if($item->equipment_code) ({{ $item->equipment_code }})@endif
                </option>
            @endif
        </select>
        <input type="hidden" name="items[{{ $index }}][unit_name]" value="{{ $item?->unit_name }}">
        <input type="hidden" name="items[{{ $index }}][equipment_code]" value="{{ $item?->equipment_code }}">
    </td>
    <td>
        <select name="items[{{ $index }}][assigned_operator_id]" class="form-select js-operator-select">
            @if($item && $item->assigned_operator_id)
                <option value="{{ $item->assigned_operator_id }}" selected>
                    {{ $item->operator_name }}
                </option>
            @endif
        </select>
        <input type="hidden" name="items[{{ $index }}][operator_name]" value="{{ $item?->operator_name }}">
    </td>
    <td>
        <div class="input-group input-group-sm">
            <input type="text" inputmode="numeric" class="form-control form-control-sm js-rupiah-input"
                   name="items[{{ $index }}][hm_start]"
                   value="{{ $item?->hm_start ?? 0 }}"
                   autocomplete="off">
            <span class="input-group-text">HM</span>
        </div>
    </td>
    <td>
        <div class="input-group input-group-sm">
            <input type="text" inputmode="numeric" class="form-control form-control-sm js-rupiah-input"
                   name="items[{{ $index }}][hm_target_monthly]"
                   value="{{ $item?->hm_target_monthly ?? 0 }}"
                   autocomplete="off">
            <span class="input-group-text">HM</span>
        </div>
    </td>
    <td>
        <select name="items[{{ $index }}][status]" class="form-select form-select-sm">
            <option value="READY" @selected(($item?->status ?? 'READY') === 'READY')>Ready</option>
            <option value="ACTIVE" @selected(($item?->status ?? '') === 'ACTIVE')>Active</option>
            <option value="DOWN" @selected(($item?->status ?? '') === 'DOWN')>Down</option>
            <option value="RETURNED" @selected(($item?->status ?? '') === 'RETURNED')>Returned</option>
            <option value="REPLACED" @selected(($item?->status ?? '') === 'REPLACED')>Replaced</option>
        </select>
    </td>
    <td>
        <input type="text" class="form-control form-control-sm"
               name="items[{{ $index }}][remarks]"
               value="{{ $item?->remarks }}"
               placeholder="Opsional">
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-soft-danger btn-sm remove-item-btn">
            <i class="ti ti-trash"></i>
        </button>
    </td>
</tr>
