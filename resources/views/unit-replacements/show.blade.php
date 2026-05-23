<?php $page = 'unit-replacements'; ?>
@extends('layout.mainlayout')
@section('title', 'PTU ' . $unitReplacement->replacement_number)
@section('content')
<div class="page-wrapper">
    <div class="content">

        <div class="d-md-flex d-block align-items-center justify-content-between mb-3">
            <div class="my-auto mb-2">
                <h3 class="page-title mb-1">{{ $unitReplacement->replacement_number }}</h3>
                <nav>
                    <ol class="breadcrumb mb-0">
                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                        <li class="breadcrumb-item"><a href="{{ route('unit-replacements.index') }}">PTU</a></li>
                        <li class="breadcrumb-item active">{{ $unitReplacement->replacement_number }}</li>
                    </ol>
                </nav>
            </div>
            <div class="d-flex my-xl-auto right-content align-items-center flex-wrap gap-2">
                <a href="{{ route('unit-replacements.index') }}" class="btn btn-light d-flex align-items-center">
                    <i class="ti ti-arrow-left me-1"></i>Kembali
                </a>
                @if($unitReplacement->attachment_path)
                <a href="{{ route('unit-replacements.attachment', $unitReplacement->uid) }}" class="btn btn-outline-info d-flex align-items-center">
                    <i class="ti ti-download me-1"></i>Lampiran
                </a>
                @endif
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show"><i class="ti ti-circle-check me-2"></i>{{ session('success') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif
        @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show"><i class="ti ti-alert-circle me-2"></i>{{ session('error') }}<button type="button" class="btn-close" data-bs-dismiss="alert"></button></div>
        @endif

        <div class="row">
            <div class="col-xl-4 col-lg-5 mb-4">
                <div class="card mb-4">
                    <div class="card-header bg-light-200">
                        <h5 class="mb-0">Ringkasan PTU</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">Status</label>
                            <span class="badge bg-{{ $unitReplacement->status->color() }} fs-13">
                                {{ $unitReplacement->status->label() }}
                            </span>
                        </div>
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">No. PTU</label>
                            <span class="fw-bold">{{ $unitReplacement->replacement_number }}</span>
                        </div>
                        <div class="row mb-3">
                            <div class="col-6">
                                <label class="text-muted d-block small mb-1">Tgl. Penggantian</label>
                                <span class="fw-bold">{{ $unitReplacement->replacement_date->format('d/m/Y') }}</span>
                            </div>
                            <div class="col-6">
                                <label class="text-muted d-block small mb-1">Tgl. Mobilisasi</label>
                                <span class="fw-bold">{{ $unitReplacement->mobilization_date ? $unitReplacement->mobilization_date->format('d/m/Y') : '-' }}</span>
                            </div>
                        </div>
                        @if($unitReplacement->cause)
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">Penyebab</label>
                            <p class="mb-0 small">{{ $unitReplacement->cause }}</p>
                        </div>
                        @endif
                        @if($unitReplacement->notes)
                        <div class="mb-3">
                            <label class="text-muted d-block small mb-1">Catatan</label>
                            <p class="mb-0 small">{{ $unitReplacement->notes }}</p>
                        </div>
                        @endif
                        <hr>
                        <div class="mb-2">
                            <label class="text-muted d-block small mb-1">Dibuat oleh</label>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-2" style="width:26px;height:26px;font-size:11px;">
                                    {{ $unitReplacement->creator ? strtoupper(substr($unitReplacement->creator->name, 0, 1)) : '?' }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fs-13">{{ $unitReplacement->creator->name ?? 'Unknown' }}</h6>
                                    <span class="text-muted" style="font-size:11px;">{{ $unitReplacement->created_at->format('d M Y H:i') }}</span>
                                </div>
                            </div>
                        </div>
                        @if($unitReplacement->approved_by)
                        <div class="mt-3">
                            <label class="text-muted d-block small mb-1">Disetujui oleh</label>
                            <div class="d-flex align-items-center">
                                <div class="avatar avatar-xs rounded-circle bg-success text-white d-flex align-items-center justify-content-center me-2" style="width:26px;height:26px;font-size:11px;">
                                    {{ $unitReplacement->approver ? strtoupper(substr($unitReplacement->approver->name, 0, 1)) : '?' }}
                                </div>
                                <div>
                                    <h6 class="mb-0 fs-13">{{ $unitReplacement->approver->name ?? 'Unknown' }}</h6>
                                    <span class="text-muted" style="font-size:11px;">{{ $unitReplacement->approved_at ? $unitReplacement->approved_at->format('d M Y H:i') : '' }}</span>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="card mb-4">
                    <div class="card-header bg-light-200"><h6 class="mb-0">Project & UR</h6></div>
                    <div class="card-body">
                        <label class="text-muted d-block small mb-1">Project</label>
                        <p class="fw-bold mb-2">{{ $unitReplacement->project->project_name ?? '-' }}</p>
                        <label class="text-muted d-block small mb-1">No. Project</label>
                        <p class="fw-bold mb-2">{{ $unitReplacement->project->project_number ?? '-' }}</p>
                        <hr class="my-2">
                        <label class="text-muted d-block small mb-1">UR Asal</label>
                        @if($unitReplacement->unitRequest)
                            <a href="{{ route('unit-requests.show', $unitReplacement->unitRequest->uid) }}" class="fw-bold link-primary">
                                {{ $unitReplacement->unitRequest->request_number }}
                            </a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                    </div>
                </div>

                @if($hasApprovalMatrix && $nextApproverLabel)
                <div class="card mb-4">
                    <div class="card-header bg-light-200"><h6 class="mb-0">Approval Berikutnya</h6></div>
                    <div class="card-body">
                        <p class="mb-0 small"><i class="ti ti-user-check me-1 text-primary"></i>{{ $nextApproverLabel }}</p>
                    </div>
                </div>
                @endif

                <div class="card">
                    <div class="card-header bg-light-200"><h6 class="mb-0">Aksi</h6></div>
                    <div class="card-body d-grid gap-2">
                        @if($unitReplacement->canEdit())
                        <a href="{{ route('unit-replacements.edit', $unitReplacement->uid) }}" class="btn btn-outline-secondary">
                            <i class="ti ti-edit me-1"></i> Edit
                        </a>
                        @endif

                        @if($unitReplacement->canSubmit() && auth()->id() === $unitReplacement->created_by)
                        <form action="{{ route('unit-replacements.submit', $unitReplacement->uid) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-info w-100">
                                <i class="ti ti-send me-1"></i> Submit untuk Approval
                            </button>
                        </form>
                        @endif

                        @if($isApprover)
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#approveModal">
                            <i class="ti ti-circle-check me-1"></i> Approve / Reject
                        </button>
                        @endif

                        @if($canForward)
                        <form action="{{ route('unit-replacements.forward', $unitReplacement->uid) }}" method="POST"
                            onsubmit="return confirm('Teruskan PTU ini ke Workshop?')">
                            @csrf
                            <button type="submit" class="btn btn-warning w-100">
                                <i class="ti ti-send me-1"></i> Teruskan ke Workshop
                            </button>
                        </form>
                        @endif

                        @if($canWorkshopDecide)
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#workshopModal">
                            <i class="ti ti-tools me-1"></i> Keputusan Workshop
                        </button>
                        @endif

                        @if($unitReplacement->status->value === 'DRAFT' && auth()->id() === $unitReplacement->created_by)
                        <form action="{{ route('unit-replacements.destroy', $unitReplacement->uid) }}" method="POST"
                            onsubmit="return confirm('Hapus PTU ini? Tidak dapat dibatalkan.')">
                            @csrf @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="ti ti-trash me-1"></i> Hapus
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-xl-8 col-lg-7">
                <div class="card mb-4">
                    <div class="card-header bg-light-200">
                        <h5 class="mb-0">Daftar Unit yang Diganti</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>#</th>
                                        <th>Unit Lama</th>
                                        <th>Unit Pengganti</th>
                                        <th>Qty</th>
                                        <th>Durasi</th>
                                        <th>Alasan</th>
                                        <th>Workshop</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($unitReplacement->items as $i => $item)
                                    <tr>
                                        <td class="text-muted small">{{ $i + 1 }}</td>
                                        <td>
                                            <span class="fw-medium text-danger">{{ $item->original_unit_name ?? '-' }}</span>
                                            @if($item->original_equipment_code)
                                                <small class="d-block text-muted">{{ $item->original_equipment_code }}</small>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="fw-medium text-success">{{ $item->replacement_unit_name ?? '-' }}</span>
                                            @if($item->replacement_equipment_code)
                                                <small class="d-block text-muted">{{ $item->replacement_equipment_code }}</small>
                                            @endif
                                        </td>
                                        <td>{{ rtrim(rtrim(number_format($item->replacement_qty, 2), '0'), '.') }}</td>
                                        <td>{{ $item->replacement_duration_days ? $item->replacement_duration_days . ' hari' : '-' }}</td>
                                        <td class="small">{{ $item->reason ?? '-' }}</td>
                                        <td>
                                            @if($item->unit_ready === true)
                                                <span class="badge bg-success-subtle text-success">Siap</span>
                                                @if($item->operator_id)
                                                    <small class="d-block text-muted">
                                                        Op: {{ $operators[$item->operator_id]['name'] ?? $item->operator_name ?? '-' }}
                                                    </small>
                                                @endif
                                            @elseif($item->unit_ready === false)
                                                <span class="badge bg-danger-subtle text-danger">Tidak Siap</span>
                                                @if($item->remarks)
                                                    <small class="d-block text-muted">{{ $item->remarks }}</small>
                                                @endif
                                            @else
                                                <span class="text-muted small">-</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">Tidak ada item.</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                @if($unitReplacement->approvals->isNotEmpty())
                <div class="card">
                    <div class="card-header bg-light-200"><h5 class="mb-0">Riwayat Approval</h5></div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-sm mb-0 align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>Level</th>
                                        <th>Approver</th>
                                        <th>Status</th>
                                        <th>Catatan</th>
                                        <th>Waktu</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($unitReplacement->approvals as $ap)
                                    <tr>
                                        <td>{{ $ap->level }}</td>
                                        <td>{{ $ap->approver->name ?? '-' }}</td>
                                        <td>
                                            @php $col = $ap->status === 'approved' ? 'success' : ($ap->status === 'rejected' ? 'danger' : 'warning'); @endphp
                                            <span class="badge bg-{{ $col }}-subtle text-{{ $col }} text-uppercase">{{ $ap->status }}</span>
                                        </td>
                                        <td class="small">{{ $ap->remarks ?? '-' }}</td>
                                        <td class="small">{{ $ap->approved_at ? $ap->approved_at->format('d M Y H:i') : '-' }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>

@if($isApprover)
<div class="modal fade" id="approveModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('unit-replacements.approve', $unitReplacement->uid) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Approve / Reject PTU</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" id="decApprove" value="approved" required>
                                <label class="form-check-label text-success fw-bold" for="decApprove">Setuju</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" id="decReject" value="rejected">
                                <label class="form-check-label text-danger fw-bold" for="decReject">Tolak</label>
                            </div>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="form-label">Catatan</label>
                        <textarea name="remarks" rows="3" class="form-control" placeholder="Opsional"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Konfirmasi</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@if($canWorkshopDecide)
<div class="modal fade" id="workshopModal" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <form action="{{ route('unit-replacements.workshop-decision', $unitReplacement->uid) }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Keputusan Workshop</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Keputusan <span class="text-danger">*</span></label>
                        <div class="d-flex gap-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" value="approved" required>
                                <label class="form-check-label text-success fw-bold">Setuju (unit pengganti siap)</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="decision" value="rejected">
                                <label class="form-check-label text-danger fw-bold">Tolak</label>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" rows="2" class="form-control"></textarea>
                    </div>

                    <h6 class="mt-4 mb-2">Detail per Item</h6>
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="table-light">
                                <tr>
                                    <th>Unit Pengganti</th>
                                    <th style="width:100px">Siap?</th>
                                    <th style="width:200px">Operator (ID)</th>
                                    <th>Nama Operator</th>
                                    <th>Catatan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($unitReplacement->items as $i => $item)
                                <tr>
                                    <td>
                                        <div class="fw-medium small">{{ $item->replacement_unit_name }}</div>
                                        <input type="hidden" name="items[{{ $i }}][id]" value="{{ $item->id }}">
                                    </td>
                                    <td>
                                        <select name="items[{{ $i }}][unit_ready]" class="form-select form-select-sm">
                                            <option value="">-</option>
                                            <option value="1" @selected($item->unit_ready === true)>Siap</option>
                                            <option value="0" @selected($item->unit_ready === false)>Tidak</option>
                                        </select>
                                    </td>
                                    <td>
                                        <input type="number" name="items[{{ $i }}][operator_id]" class="form-control form-control-sm"
                                            value="{{ $item->operator_id }}" placeholder="ID operator">
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $i }}][operator_name]" class="form-control form-control-sm"
                                            value="{{ $item->operator_name }}" placeholder="Nama operator">
                                    </td>
                                    <td>
                                        <input type="text" name="items[{{ $i }}][remarks]" class="form-control form-control-sm"
                                            value="{{ $item->remarks }}">
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Submit Keputusan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endif

@endsection
