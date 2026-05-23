{{--
    One row for member table. Required vars: $index (int|'__INDEX__'), $member (WorkforceFormationMember|null)
--}}
<tr>
    <td>
        <select name="members[{{ $index }}][employee_id]" class="form-select" required>
            @if($member)
                <option value="{{ $member->employee_id }}" selected>
                    {{ $member->employee_name }} — {{ $member->position_name }}
                </option>
            @endif
        </select>
        <input type="hidden" name="members[{{ $index }}][employee_name]" value="{{ $member?->employee_name }}">
        <input type="hidden" name="members[{{ $index }}][position_name]" value="{{ $member?->position_name }}">
    </td>
    <td>
        <span class="position-display text-muted small">{{ $member?->position_name ?? '-' }}</span>
    </td>
    <td>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="text" inputmode="numeric" class="form-control text-end js-rupiah-input"
                   name="members[{{ $index }}][daily_rate]"
                   value="{{ $member?->daily_rate ?? 0 }}"
                   placeholder="0"
                   autocomplete="off">
        </div>
    </td>
    <td>
        <div class="input-group">
            <span class="input-group-text">Rp</span>
            <input type="text" inputmode="numeric" class="form-control text-end js-rupiah-input"
                   name="members[{{ $index }}][allowance]"
                   value="{{ $member?->allowance ?? 0 }}"
                   placeholder="0"
                   autocomplete="off">
        </div>
    </td>
    <td>
        <select name="members[{{ $index }}][shift]" class="form-select">
            <option value="DAY" @selected(($member?->shift ?? 'DAY') === 'DAY')>Day</option>
            <option value="NIGHT" @selected(($member?->shift ?? '') === 'NIGHT')>Night</option>
            <option value="ROTATING" @selected(($member?->shift ?? '') === 'ROTATING')>Rotating</option>
        </select>
    </td>
    <td>
        <input type="date" class="form-control"
               name="members[{{ $index }}][start_date]"
               value="{{ $member?->start_date?->format('Y-m-d') }}">
    </td>
    <td>
        <input type="date" class="form-control"
               name="members[{{ $index }}][end_date]"
               value="{{ $member?->end_date?->format('Y-m-d') }}">
    </td>
    <td class="text-center">
        <button type="button" class="btn btn-soft-danger btn-sm remove-member-btn" title="Hapus anggota">
            <i class="ti ti-trash"></i>
        </button>
    </td>
</tr>
