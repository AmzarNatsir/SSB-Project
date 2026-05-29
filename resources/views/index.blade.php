<?php $page = 'index'; ?>
@extends('layout.mainlayout')
@section('content')

    <!-- ========================
        Start Page Content
    ========================= -->

    <div class="page-wrapper">

        <!-- Start Content -->
        <div class="content pb-0">

            <!-- Page Header -->
            <div class="d-flex align-items-center justify-content-between gap-2 mb-4 flex-wrap">
                <div>
                    <h4 class="mb-0">Project - Dashboard</h4>
                </div>
                <div class="gap-2 d-flex align-items-center flex-wrap">
                    <div class="daterangepick form-control w-auto d-flex align-items-center">
                        <i class="ti ti-calendar text-dark me-2"></i>
                        <span class="reportrange-picker-field text-dark">23 May 2025 - 30 May 2025</span>
                    </div>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Refresh" data-bs-original-title="Refresh"><i class="ti ti-refresh"></i></a>
                    <a href="javascript:void(0);" class="btn btn-icon btn-outline-light shadow" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="Collapse" data-bs-original-title="Collapse" id="collapse-header"><i class="ti ti-transition-top"></i></a>
                </div>
            </div>
            <!-- End Page Header -->

            <!-- start row -->
            <div class="row"></div>
            <!-- end row -->

            {{-- ==================== WORKFLOW APLIKASI ==================== --}}
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom d-flex align-items-center justify-content-between flex-wrap gap-2">
                    <div>
                        <h5 class="mb-1"><i class="ti ti-route me-1 text-primary"></i>Alur Kerja Proyek</h5>
                        <small class="text-muted">Lifecycle proyek dari pendaftaran sampai penutupan. Klik step untuk membuka modul.</small>
                    </div>
                </div>
                <div class="card-body workflow-wrapper">

                    {{-- ===== FASE 1: PRA-PROYEK ===== --}}
                    <div class="wf-phase wf-phase-1">
                        <div class="wf-phase-header">
                            <span class="wf-phase-pill"></span>
                            <div class="wf-phase-title">
                                <h6 class="mb-0">Fase 1 — Pra-Proyek <span class="text-muted fw-normal">(Planning)</span></h6>
                                <small class="text-muted">Dari pendaftaran proyek sampai kontrak final ditandatangani</small>
                            </div>
                            <span class="badge bg-danger-transparent text-danger ms-auto">6 step</span>
                        </div>
                        <div class="row g-3 mt-1">
                            @php
                                $phase1 = [
                                    ['no' => 1, 'icon' => 'ti-folder-plus',  'title' => 'Project Registration', 'sub' => 'Pendaftaran proyek baru',           'route' => 'projects.index'],
                                    ['no' => 2, 'icon' => 'ti-clipboard-check','title' => 'Feasibility Survey',  'sub' => 'Survey kelayakan multi-departemen','route' => 'project-survey.index'],
                                    ['no' => 3, 'icon' => 'ti-calculator',   'title' => 'Budget Planning',      'sub' => 'Penyusunan RAB / budget',          'route' => 'budgets.index'],
                                    ['no' => 4, 'icon' => 'ti-file-invoice', 'title' => 'Quotation',            'sub' => 'Penawaran ke owner',               'route' => 'quotations.index'],
                                    ['no' => 5, 'icon' => 'ti-message-2',    'title' => 'Negotiation',          'sub' => 'Negosiasi harga dengan owner',     'route' => 'negotiations.index'],
                                    ['no' => 6, 'icon' => 'ti-file-certificate','title' => 'Final Contract',    'sub' => 'Kontrak final ditandatangani',     'route' => 'final-contracts.index'],
                                ];
                            @endphp
                            @foreach($phase1 as $s)
                                <div class="col-md-6 col-lg-4">
                                    <a href="{{ route($s['route']) }}" class="wf-step wf-step-1">
                                        <div class="wf-step-no">{{ $s['no'] }}</div>
                                        <div class="wf-step-body">
                                            <div class="wf-step-title"><i class="ti {{ $s['icon'] }} me-1"></i>{{ $s['title'] }}</div>
                                            <div class="wf-step-sub">{{ $s['sub'] }}</div>
                                        </div>
                                        <i class="ti ti-arrow-right wf-step-arrow"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="wf-connector"><i class="ti ti-arrow-down"></i></div>

                    {{-- ===== FASE 2: MOBILISASI ===== --}}
                    <div class="wf-phase wf-phase-2">
                        <div class="wf-phase-header">
                            <span class="wf-phase-pill"></span>
                            <div class="wf-phase-title">
                                <h6 class="mb-0">Fase 2 — Mobilisasi <span class="text-muted fw-normal">(Mobilization)</span></h6>
                                <small class="text-muted">Penyiapan unit & tim sebelum eksekusi lapangan</small>
                            </div>
                            <span class="badge bg-warning-transparent text-warning ms-auto">3 step</span>
                        </div>
                        <div class="row g-3 mt-1">
                            @php
                                $phase2 = [
                                    ['no' => 7, 'icon' => 'ti-truck-delivery', 'title' => 'Unit Request',          'sub' => 'Permintaan unit ke workshop',          'route' => 'unit-requests.index'],
                                    ['no' => 8, 'icon' => 'ti-users-group',    'title' => 'SK Penugasan Tim',      'sub' => 'Workforce formation (anggota tim)',    'route' => 'workforce-formations.index'],
                                    ['no' => 9, 'icon' => 'ti-bulldozer',      'title' => 'SK Penetapan Unit',     'sub' => 'Unit formation (alat yang ditugaskan)','route' => 'unit-formations.index'],
                                ];
                            @endphp
                            @foreach($phase2 as $s)
                                <div class="col-md-6 col-lg-4">
                                    <a href="{{ route($s['route']) }}" class="wf-step wf-step-2">
                                        <div class="wf-step-no">{{ $s['no'] }}</div>
                                        <div class="wf-step-body">
                                            <div class="wf-step-title"><i class="ti {{ $s['icon'] }} me-1"></i>{{ $s['title'] }}</div>
                                            <div class="wf-step-sub">{{ $s['sub'] }}</div>
                                        </div>
                                        <i class="ti ti-arrow-right wf-step-arrow"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="wf-connector"><i class="ti ti-arrow-down"></i></div>

                    {{-- ===== FASE 3: PELAKSANAAN ===== --}}
                    <div class="wf-phase wf-phase-3">
                        <div class="wf-phase-header">
                            <span class="wf-phase-pill"></span>
                            <div class="wf-phase-title">
                                <h6 class="mb-0">Fase 3 — Pelaksanaan <span class="text-muted fw-normal">(Execution)</span></h6>
                                <small class="text-muted">Operasional harian + adjustment unit di lapangan</small>
                            </div>
                            <span class="badge bg-info-transparent text-info ms-auto">2 utama + 3 adj.</span>
                        </div>
                        <div class="row g-3 mt-1">
                            @php
                                $phase3 = [
                                    ['no' => 10, 'icon' => 'ti-clock-hour-4',  'title' => 'Daily Timesheet',    'sub' => 'Pencatatan jam kerja harian',     'route' => 'timesheets.index'],
                                    ['no' => 11, 'icon' => 'ti-progress-check','title' => 'Work Realization',   'sub' => 'Realisasi pekerjaan & volume',    'route' => 'work-realizations.index'],
                                ];
                            @endphp
                            @foreach($phase3 as $s)
                                <div class="col-md-6 col-lg-4">
                                    <a href="{{ route($s['route']) }}" class="wf-step wf-step-3">
                                        <div class="wf-step-no">{{ $s['no'] }}</div>
                                        <div class="wf-step-body">
                                            <div class="wf-step-title"><i class="ti {{ $s['icon'] }} me-1"></i>{{ $s['title'] }}</div>
                                            <div class="wf-step-sub">{{ $s['sub'] }}</div>
                                        </div>
                                        <i class="ti ti-arrow-right wf-step-arrow"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>

                        <div class="wf-sub-section mt-3">
                            <small class="text-muted fw-semibold d-block mb-2"><i class="ti ti-tool me-1"></i>Adjustment Unit (kondisional)</small>
                            <div class="row g-2">
                                @php
                                    $phase3Adj = [
                                        ['icon' => 'ti-replace',        'title' => 'PTU — Penggantian Unit',  'sub' => 'Ganti unit rusak / breakdown',   'route' => 'unit-replacements.index'],
                                        ['icon' => 'ti-arrow-back-up',  'title' => 'PPU — Pengembalian Unit', 'sub' => 'Kembalikan unit ke workshop',    'route' => 'unit-returns.index'],
                                        ['icon' => 'ti-transfer',       'title' => 'Transfer Unit',           'sub' => 'Pindah unit antar proyek',       'route' => 'unit-transfers.index'],
                                    ];
                                @endphp
                                @foreach($phase3Adj as $s)
                                    <div class="col-md-4">
                                        <a href="{{ route($s['route']) }}" class="wf-step wf-step-3 wf-step-sm">
                                            <div class="wf-step-body">
                                                <div class="wf-step-title"><i class="ti {{ $s['icon'] }} me-1"></i>{{ $s['title'] }}</div>
                                                <div class="wf-step-sub">{{ $s['sub'] }}</div>
                                            </div>
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="wf-connector"><i class="ti ti-arrow-down"></i></div>

                    {{-- ===== FASE 4: KEUANGAN & CLOSING ===== --}}
                    <div class="wf-phase wf-phase-4">
                        <div class="wf-phase-header">
                            <span class="wf-phase-pill"></span>
                            <div class="wf-phase-title">
                                <h6 class="mb-0">Fase 4 — Keuangan & Closing <span class="text-muted fw-normal">(Financial &amp; Closing)</span></h6>
                                <small class="text-muted">Penagihan, pencairan, sampai proyek ditutup</small>
                            </div>
                            <span class="badge bg-success-transparent text-success ms-auto">3 step</span>
                        </div>
                        <div class="row g-3 mt-1">
                            @php
                                $phase4 = [
                                    ['no' => 12, 'icon' => 'ti-receipt-2',  'title' => 'Invoice',              'sub' => 'Penerbitan invoice ke owner',     'route' => 'invoices.index'],
                                    ['no' => 13, 'icon' => 'ti-coin',       'title' => 'Receivable',           'sub' => 'Monitoring piutang',              'route' => 'receivables.index'],
                                    ['no' => 14, 'icon' => 'ti-cash-banknote','title' => 'Receivable Settlement','sub' => 'Pelunasan pembayaran',          'route' => 'receivable-settlements.index'],
                                ];
                            @endphp
                            @foreach($phase4 as $s)
                                <div class="col-md-6 col-lg-4">
                                    <a href="{{ route($s['route']) }}" class="wf-step wf-step-4">
                                        <div class="wf-step-no">{{ $s['no'] }}</div>
                                        <div class="wf-step-body">
                                            <div class="wf-step-title"><i class="ti {{ $s['icon'] }} me-1"></i>{{ $s['title'] }}</div>
                                            <div class="wf-step-sub">{{ $s['sub'] }}</div>
                                        </div>
                                        <i class="ti ti-arrow-right wf-step-arrow"></i>
                                    </a>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    {{-- ===== PARALLEL MODULES ===== --}}
                    <div class="row g-3 mt-4">
                        <div class="col-lg-6">
                            <div class="wf-parallel-card">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti ti-wallet text-purple me-2 fs-4"></i>
                                    <h6 class="mb-0">Modul Pendukung <span class="text-muted fw-normal small">(berjalan paralel)</span></h6>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('petty-cash-requests.index') }}" class="badge bg-light text-dark border px-3 py-2"><i class="ti ti-cash me-1"></i>Petty Cash Request</a>
                                    <a href="{{ route('petty-cash-payments.index') }}" class="badge bg-light text-dark border px-3 py-2"><i class="ti ti-credit-card me-1"></i>Petty Cash Payment</a>
                                    <a href="{{ route('petty-cash-purchases.index') }}" class="badge bg-light text-dark border px-3 py-2"><i class="ti ti-shopping-cart me-1"></i>Petty Cash Purchase</a>
                                    <a href="{{ route('approval-flows.index') }}" class="badge bg-light text-dark border px-3 py-2"><i class="ti ti-checks me-1"></i>Approval Flow</a>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="wf-parallel-card">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="ti ti-settings text-secondary me-2 fs-4"></i>
                                    <h6 class="mb-0">Master Data <span class="text-muted fw-normal small">(setup awal)</span></h6>
                                </div>
                                <div class="d-flex flex-wrap gap-2">
                                    <a href="{{ route('project-category.index') }}" class="badge bg-light text-dark border px-3 py-2"><i class="ti ti-category me-1"></i>Project Category</a>
                                    <a href="{{ route('equipment-rental-rates-hm.index') }}" class="badge bg-light text-dark border px-3 py-2"><i class="ti ti-engine me-1"></i>Tarif HM Alat</a>
                                    <a href="{{ route('scoring.index') }}" class="badge bg-light text-dark border px-3 py-2"><i class="ti ti-list-check me-1"></i>Scoring Criteria</a>
                                    <a href="{{ route('petty-cash-categories.index') }}" class="badge bg-light text-dark border px-3 py-2"><i class="ti ti-tags me-1"></i>PC Category</a>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <style>
                .workflow-wrapper .wf-phase {
                    border-left: 4px solid #dee2e6;
                    padding: 14px 16px;
                    border-radius: 6px;
                    background: #fafbfc;
                }
                .workflow-wrapper .wf-phase-1 { border-left-color: #dc3545; }
                .workflow-wrapper .wf-phase-2 { border-left-color: #fd7e14; }
                .workflow-wrapper .wf-phase-3 { border-left-color: #0d6efd; }
                .workflow-wrapper .wf-phase-4 { border-left-color: #198754; }

                .workflow-wrapper .wf-phase-header {
                    display: flex;
                    align-items: center;
                    gap: 10px;
                    margin-bottom: 4px;
                }
                .workflow-wrapper .wf-phase-pill {
                    width: 10px; height: 10px; border-radius: 50%;
                    display: inline-block;
                }
                .workflow-wrapper .wf-phase-1 .wf-phase-pill { background: #dc3545; }
                .workflow-wrapper .wf-phase-2 .wf-phase-pill { background: #fd7e14; }
                .workflow-wrapper .wf-phase-3 .wf-phase-pill { background: #0d6efd; }
                .workflow-wrapper .wf-phase-4 .wf-phase-pill { background: #198754; }

                .workflow-wrapper .wf-connector {
                    text-align: center;
                    color: #adb5bd;
                    margin: 8px 0;
                    font-size: 22px;
                }

                .workflow-wrapper .wf-step {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 12px 14px;
                    background: #fff;
                    border: 1px solid #e9ecef;
                    border-radius: 8px;
                    text-decoration: none;
                    color: inherit;
                    transition: all .15s ease;
                    height: 100%;
                }
                .workflow-wrapper .wf-step:hover {
                    transform: translateY(-2px);
                    box-shadow: 0 4px 12px rgba(0,0,0,.08);
                }
                .workflow-wrapper .wf-step-1:hover { border-color: #dc3545; }
                .workflow-wrapper .wf-step-2:hover { border-color: #fd7e14; }
                .workflow-wrapper .wf-step-3:hover { border-color: #0d6efd; }
                .workflow-wrapper .wf-step-4:hover { border-color: #198754; }

                .workflow-wrapper .wf-step-no {
                    flex: 0 0 32px;
                    width: 32px; height: 32px;
                    border-radius: 50%;
                    display: flex; align-items: center; justify-content: center;
                    font-weight: 700;
                    font-size: 13px;
                    color: #fff;
                }
                .workflow-wrapper .wf-step-1 .wf-step-no { background: #dc3545; }
                .workflow-wrapper .wf-step-2 .wf-step-no { background: #fd7e14; }
                .workflow-wrapper .wf-step-3 .wf-step-no { background: #0d6efd; }
                .workflow-wrapper .wf-step-4 .wf-step-no { background: #198754; }

                .workflow-wrapper .wf-step-body { flex: 1; min-width: 0; }
                .workflow-wrapper .wf-step-title {
                    font-weight: 600; font-size: 13px;
                    color: #212529;
                    margin-bottom: 2px;
                }
                .workflow-wrapper .wf-step-sub {
                    font-size: 11.5px; color: #6c757d;
                    line-height: 1.3;
                }
                .workflow-wrapper .wf-step-arrow {
                    color: #adb5bd; font-size: 16px;
                    flex-shrink: 0;
                }
                .workflow-wrapper .wf-step-sm { padding: 10px 12px; }

                .workflow-wrapper .wf-sub-section {
                    background: rgba(13, 110, 253, .04);
                    border-radius: 6px;
                    padding: 12px;
                }

                .workflow-wrapper .wf-parallel-card {
                    background: #fff;
                    border: 1px dashed #ced4da;
                    border-radius: 8px;
                    padding: 14px;
                    height: 100%;
                }
                .workflow-wrapper .wf-parallel-card a.badge {
                    text-decoration: none;
                    font-weight: 500;
                }
                .workflow-wrapper .wf-parallel-card a.badge:hover {
                    background: #e9ecef !important;
                }

                @media (max-width: 575px) {
                    .workflow-wrapper .wf-step-arrow { display: none; }
                    .workflow-wrapper .wf-step { padding: 10px 12px; }
                }
            </style>
            {{-- ==================== END WORKFLOW ==================== --}}
        </div>
        <!-- End Content -->
        @component('components.footer')
        @endcomponent
    </div>
    <!-- ========================
        End Page Content
    ========================= -->
@endsection
