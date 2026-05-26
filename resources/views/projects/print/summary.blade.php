<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Project Summary - {{ $project->project_name }}</title>
    <style>
        @page { margin: 60px 40px 50px 40px; }
        body { font-family: Arial, sans-serif; font-size: 11px; color: #222; }
        h1, h2, h3, h4 { margin: 0 0 8px 0; }
        .cover { text-align: center; padding-top: 120px; }
        .cover .logo-box { font-size: 14px; color: #777; margin-bottom: 40px; }
        .cover .report-title { font-size: 16px; letter-spacing: 4px; color: #555; }
        .cover .divider { border: none; border-top: 2px solid #2c3e50; margin: 12px auto 40px; width: 80px; }
        .cover .project-card {
            border: 2px solid #2c3e50;
            border-radius: 6px;
            padding: 36px 24px;
            margin: 0 60px 40px;
        }
        .cover .project-name { font-size: 22px; font-weight: bold; color: #2c3e50; }
        .cover .project-number { font-size: 13px; color: #555; margin-top: 8px; }
        .cover .meta { margin: 0 60px; }
        .cover .meta table { width: 100%; border-collapse: collapse; }
        .cover .meta td { padding: 6px 8px; font-size: 12px; vertical-align: top; }
        .cover .meta td.label { color: #777; width: 22%; }
        .cover .meta td.value { color: #222; font-weight: bold; width: 28%; }
        .cover .footer-meta { margin-top: 60px; font-size: 10px; color: #777; }

        .section { margin-bottom: 20px; }
        .section-title {
            background-color: #2c3e50;
            color: #fff;
            padding: 8px 14px;
            font-size: 13px;
            font-weight: bold;
            margin: 0 0 12px 0;
            border-radius: 3px;
        }
        .sub-title {
            font-size: 12px;
            font-weight: bold;
            color: #2c3e50;
            border-bottom: 1px solid #ccc;
            padding-bottom: 4px;
            margin: 14px 0 8px 0;
        }
        .info-table { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        .info-table td { padding: 4px 6px; vertical-align: top; }
        .info-table td.label { width: 22%; color: #555; }
        .info-table td.sep { width: 1%; }

        table.data { width: 100%; border-collapse: collapse; margin-bottom: 12px; }
        table.data th, table.data td { border: 1px solid #ddd; padding: 6px 8px; }
        table.data th { background-color: #f2f2f2; font-weight: bold; text-align: left; font-size: 10px; }
        table.data td { font-size: 10px; vertical-align: top; }
        table.data tfoot td { background-color: #f9f9f9; font-weight: bold; }

        .badge { padding: 2px 8px; border-radius: 3px; font-size: 9px; color: #fff; }
        .badge-success { background-color: #27ae60; }
        .badge-danger { background-color: #e74c3c; }
        .badge-warning { background-color: #f39c12; }
        .badge-info { background-color: #3498db; }
        .badge-secondary { background-color: #7f8c8d; }
        .badge-primary { background-color: #2c3e50; }

        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-muted { color: #888; }
        .empty-state { padding: 16px; text-align: center; color: #888; border: 1px dashed #ddd; border-radius: 4px; }
        .notes-box { border: 1px solid #ddd; padding: 8px; background-color: #fafafa; }
        .page-break { page-break-after: always; }
        .avoid-break { page-break-inside: avoid; }

        .dept-header {
            background-color: #2c3e50; color: #fff;
            padding: 8px 12px; font-size: 13px; font-weight: bold;
            margin-bottom: 10px; border-radius: 3px;
        }
        .criterion-box {
            border: 1px solid #ddd; border-radius: 3px;
            padding: 8px; margin-bottom: 8px; page-break-inside: avoid;
        }
        .criterion-head {
            background-color: #f2f2f2; padding: 5px 8px;
            font-weight: bold; font-size: 10px; margin-bottom: 5px;
        }
        .check-box {
            display: inline-block; width: 10px; height: 10px;
            border: 1px solid #000; text-align: center; line-height: 10px;
            font-size: 9px;
        }

        .page-footer {
            position: fixed; bottom: -40px; left: 0; right: 0;
            font-size: 9px; color: #888; text-align: center;
        }
        .page-header {
            position: fixed; top: -50px; left: 0; right: 0;
            font-size: 9px; color: #888;
            border-bottom: 1px solid #eee; padding-bottom: 4px;
        }
        .page-header .left { float: left; }
        .page-header .right { float: right; }
    </style>
</head>
<body>

@php
    $statusMap = [
        'NOT STARTED' => ['Plan', 'badge-primary'],
        'ON PROGRESS' => ['Survey', 'badge-info'],
        'COMPLETED'   => ['Completed', 'badge-success'],
        'AMENDMENT'   => ['Amendment', 'badge-danger'],
        'ON HOLD'     => ['On Hold', 'badge-warning'],
        'CANCELLED'   => ['Cancelled', 'badge-danger'],
    ];
    $statusInfo = $statusMap[$project->project_status] ?? [$project->project_status, 'badge-secondary'];

    $latestSurvey = $project->surveys->first();
    $unitMasuk = $project->unitTransfersIn ?? collect();
    $unitKeluar = $project->unitTransfersOut ?? collect();

    $unitRequests = $project->unitRequests ?? collect();
@endphp

{{-- ===================== PAGE HEADER & FOOTER (from page 2 onwards) ===================== --}}
<div class="page-header" style="display: none;"></div>

{{-- ============================================================= --}}
{{-- HALAMAN 1: COVER                                                --}}
{{-- ============================================================= --}}
<div class="cover">
    <div class="logo-box">[ SSB PROJECT MANAGEMENT ]</div>
    <div class="report-title">PROJECT SUMMARY REPORT</div>
    <hr class="divider">

    <div class="project-card">
        <div class="project-name">{{ $project->project_name }}</div>
        <div class="project-number">No. {{ $project->project_number ?? '-' }}</div>
        <div style="margin-top: 14px;">
            <span class="badge {{ $statusInfo[1] }}">{{ $statusInfo[0] }}</span>
        </div>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td class="label">Client</td>
                <td class="value">{{ $project->user_name ?? '-' }}</td>
                <td class="label">PIC</td>
                <td class="value">{{ $project->pic->name ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kategori</td>
                <td class="value">{{ $project->category->name ?? '-' }}{{ $project->subCategory ? ' / ' . $project->subCategory->name : '' }}</td>
                <td class="label">Nilai Proyek</td>
                <td class="value">Rp {{ number_format($project->project_value ?? 0, 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="label">Mulai</td>
                <td class="value">{{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}</td>
                <td class="label">Selesai</td>
                <td class="value">{{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Lokasi</td>
                <td class="value" colspan="3">{{ $project->project_location ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <div class="footer-meta">
        Dicetak: {{ now()->format('d M Y H:i') }}
        @auth &bull; Oleh: {{ auth()->user()->name }} @endauth
    </div>
</div>
<div class="page-break"></div>

{{-- ============================================================= --}}
{{-- HALAMAN 2: HASIL SURVEY (RINGKASAN)                             --}}
{{-- ============================================================= --}}
<div class="section">
    <div class="section-title">HASIL SURVEY KELAYAKAN PROJECT</div>

    @if(!$latestSurvey)
        <div class="empty-state">Belum ada data survey untuk project ini.</div>
    @else
        @php
            $surveyScores = $latestSurvey->scores ?? collect();
        @endphp

        <div class="sub-title">Informasi Project</div>
        <table class="info-table">
            <tr>
                <td class="label">Project Name</td><td class="sep">:</td><td>{{ $project->project_name }}</td>
            </tr>
            <tr>
                <td class="label">Project Code</td><td class="sep">:</td><td>{{ $project->project_number ?? '-' }}</td>
            </tr>
            <tr>
                <td class="label">Status Survey</td><td class="sep">:</td><td>{{ str_replace('_', ' ', $latestSurvey->status ?? '-') }}</td>
            </tr>
        </table>

        <div class="sub-title">Jadwal & Tim Survey</div>
        <table class="info-table">
            <tr>
                <td class="label">Tanggal/Jam</td><td class="sep">:</td>
                <td>{{ $latestSurvey->scheduled_at ? \Carbon\Carbon::parse($latestSurvey->scheduled_at)->format('d M Y H:i') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Tim Surveyor</td><td class="sep">:</td>
                <td>
                    @forelse($latestSurvey->teams ?? [] as $member)
                        &bull; {{ $member->user->name ?? '-' }}{{ !$loop->last ? '<br>' : '' }}
                    @empty
                        <span class="text-muted">-</span>
                    @endforelse
                </td>
            </tr>
        </table>

        <div class="sub-title">Ringkasan Penilaian per Departemen</div>
        <table class="data">
            <thead>
                <tr>
                    <th width="5%">No</th>
                    <th width="30%">Departemen</th>
                    <th width="15%" class="text-right">Skor (%)</th>
                    <th width="15%" class="text-right">Bobot (%)</th>
                    <th width="15%" class="text-right">Tertimbang</th>
                    <th width="20%">Evaluator</th>
                </tr>
            </thead>
            <tbody>
                @forelse($surveyScores as $idx => $score)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $score->department ?? '-' }}</td>
                        <td class="text-right">{{ number_format($score->score, 2) }}</td>
                        <td class="text-right">{{ number_format($score->weight, 0) }}</td>
                        <td class="text-right">{{ number_format($score->weighted_score, 2) }}</td>
                        <td>{{ $score->submitter->name ?? '-' }}</td>
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center text-muted">Belum ada penilaian.</td></tr>
                @endforelse
            </tbody>
            @if($surveyScores->count())
            <tfoot>
                <tr>
                    <td colspan="4" class="text-right">Total Weighted Score:</td>
                    <td class="text-right">{{ number_format($latestSurvey->total_score ?? 0, 2) }}</td>
                    <td>
                        @if($latestSurvey->total_score !== null)
                            @if($latestSurvey->is_feasible)
                                <span class="badge badge-success">FEASIBLE</span>
                            @else
                                <span class="badge badge-danger">NOT FEASIBLE</span>
                            @endif
                        @endif
                    </td>
                </tr>
            </tfoot>
            @endif
        </table>

        @if(!empty($latestSurvey->metadata['feasibility_recommendation'] ?? null))
            <div class="sub-title">Rekomendasi Kelayakan</div>
            <div class="notes-box">{!! nl2br(e($latestSurvey->metadata['feasibility_recommendation'])) !!}</div>
        @endif

        @if(($latestSurvey->documents ?? collect())->count())
            <div class="sub-title">Dokumen Survey</div>
            <ul style="margin: 0; padding-left: 18px;">
                @foreach($latestSurvey->documents as $doc)
                    <li>{{ $doc->document_name ?? basename($doc->document_path) }}
                        <span class="text-muted">— diupload oleh {{ $doc->uploader->name ?? '-' }} ({{ $doc->created_at?->format('d M Y') }})</span>
                    </li>
                @endforeach
            </ul>
        @endif
    @endif
</div>

{{-- ============================================================= --}}
{{-- HASIL SURVEY: DETAIL PER DEPARTEMEN                             --}}
{{-- ============================================================= --}}
@if($latestSurvey && ($latestSurvey->scores ?? collect())->count())
    @foreach($latestSurvey->scores as $score)
        <div class="page-break"></div>
        <div class="dept-header">{{ strtoupper($score->department ?? 'DEPARTMENT') }} — DEPARTMENT ASSESSMENT</div>

        <table class="info-table">
            <tr>
                <td class="label" width="20%">Evaluator</td><td class="sep">:</td>
                <td width="30%">{{ $score->submitter->name ?? '-' }}</td>
                <td class="label" width="20%">Skor</td><td class="sep">:</td>
                <td>{{ number_format($score->score, 2) }} / 100</td>
            </tr>
            <tr>
                <td class="label">Tanggal Submit</td><td class="sep">:</td>
                <td>{{ $score->created_at?->format('d M Y H:i') }}</td>
                <td class="label">Bobot</td><td class="sep">:</td>
                <td>{{ number_format($score->weight, 0) }}%</td>
            </tr>
            <tr>
                <td class="label">Weighted Score</td><td class="sep">:</td>
                <td colspan="4"><strong>{{ number_format($score->weighted_score, 2) }}</strong></td>
            </tr>
        </table>

        <div class="sub-title">Kriteria Penilaian</div>
        @forelse($score->criteria ?? [] as $idx => $crit)
            @php
                $masterCriteria = \App\Models\ScoringCriteria::with('options')->where('name', $crit->criterion_name)->first();
            @endphp
            <div class="criterion-box">
                <div class="criterion-head">
                    {{ $idx + 1 }}. {{ $crit->criterion_name }}
                    <span style="float: right; font-weight: normal;">Weight: {{ $masterCriteria->weighting ?? '-' }}</span>
                </div>
                @if($masterCriteria && $masterCriteria->options->count())
                    <table style="width: 100%;">
                        @foreach($masterCriteria->options as $opt)
                            @php $isSelected = ($crit->justification == ($opt->label . ' (' . $opt->score . ' pts)')); @endphp
                            <tr>
                                <td width="4%" style="vertical-align: top;">
                                    <span class="check-box">{!! $isSelected ? '&#10003;' : '&nbsp;' !!}</span>
                                </td>
                                <td width="80%" style="padding: 2px 4px;">
                                    <strong style="{{ $isSelected ? 'color: #000;' : 'color: #999;' }}">{{ $opt->label }}</strong><br>
                                    <span style="font-size: 9px; color: {{ $isSelected ? '#333' : '#aaa' }};">{{ $opt->description }}</span>
                                </td>
                                <td width="16%" class="text-right" style="{{ $isSelected ? 'font-weight: bold;' : 'color: #999;' }}">
                                    {{ $opt->score }} pts
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <div><strong>Selected:</strong> {{ $crit->justification }} ({{ floatval($crit->score) }} pts)</div>
                @endif
            </div>
        @empty
            <div class="empty-state">Tidak ada detail kriteria.</div>
        @endforelse

        @if(!empty($score->notes))
            <div class="sub-title">Catatan Penilaian</div>
            <div class="notes-box">{!! nl2br(e($score->notes)) !!}</div>
        @endif
    @endforeach
@endif

{{-- ============================================================= --}}
{{-- PROJECT DETAILS                                                 --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">DETAIL PROJECT</div>
    <table class="info-table">
        <tr>
            <td class="label" width="22%">Project Name</td><td class="sep">:</td>
            <td>{{ $project->project_name }}</td>
        </tr>
        <tr>
            <td class="label">Project Number</td><td class="sep">:</td>
            <td>{{ $project->project_number ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Kategori</td><td class="sep">:</td>
            <td>{{ $project->category->name ?? '-' }}{{ $project->subCategory ? ' / ' . $project->subCategory->name : '' }}</td>
        </tr>
        <tr>
            <td class="label">Job Type</td><td class="sep">:</td>
            <td>{{ $project->job_type ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Client</td><td class="sep">:</td>
            <td>{{ $project->user_name ?? '-' }}{{ $project->user_code ? ' (' . $project->user_code . ')' : '' }}</td>
        </tr>
        <tr>
            <td class="label">Alamat Client</td><td class="sep">:</td>
            <td>{{ $project->user_address ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Kontak</td><td class="sep">:</td>
            <td>{{ $project->email ?? '-' }}{{ $project->phone_number ? ' / ' . $project->phone_number : '' }}</td>
        </tr>
        <tr>
            <td class="label">NPWP</td><td class="sep">:</td>
            <td>{{ $project->taxpayer_id ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">PIC</td><td class="sep">:</td>
            <td>{{ $project->pic->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Lokasi</td><td class="sep">:</td>
            <td>{{ $project->project_location ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Koordinat</td><td class="sep">:</td>
            <td>{{ $project->project_coordinates ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Periode</td><td class="sep">:</td>
            <td>
                {{ $project->start_date ? \Carbon\Carbon::parse($project->start_date)->format('d M Y') : '-' }}
                s/d
                {{ $project->end_date ? \Carbon\Carbon::parse($project->end_date)->format('d M Y') : '-' }}
                ({{ $project->duration_of_work ?? '-' }} hari)
            </td>
        </tr>
        <tr>
            <td class="label">Nilai Proyek</td><td class="sep">:</td>
            <td><strong>Rp {{ number_format($project->project_value ?? 0, 0, ',', '.') }}</strong></td>
        </tr>
        <tr>
            <td class="label">Tarif Sewa</td><td class="sep">:</td>
            <td>{{ $project->equipmentRentalRate->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Rekening Bank</td><td class="sep">:</td>
            <td>{{ $project->bank_account ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Scope of Work</td><td class="sep">:</td>
            <td>{!! nl2br(e($project->scope_of_work ?? '-')) !!}</td>
        </tr>
        <tr>
            <td class="label">Deskripsi</td><td class="sep">:</td>
            <td>{!! nl2br(e($project->description ?? '-')) !!}</td>
        </tr>
    </table>
</div>

{{-- ============================================================= --}}
{{-- BUDGET & QUOTATION                                              --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">RAB (BUDGET) & PENAWARAN (QUOTATION)</div>

    <div class="sub-title">RAB / Budget</div>
    @if($project->latest_budget)
        @php $b = $project->latest_budget; @endphp
        <table class="info-table">
            <tr><td class="label" width="22%">Versi</td><td class="sep">:</td><td>v{{ $b->version ?? '-' }} ({{ $b->status ?? '-' }})</td></tr>
            <tr><td class="label">Total HPP</td><td class="sep">:</td><td>Rp {{ number_format($b->total_hpp ?? 0, 0, ',', '.') }}</td></tr>
            <tr><td class="label">Margin</td><td class="sep">:</td><td>{{ number_format($b->profit_margin_percent ?? 0, 2) }}%</td></tr>
            <tr><td class="label">Selling Price</td><td class="sep">:</td><td><strong>Rp {{ number_format($b->selling_price ?? 0, 0, ',', '.') }}</strong></td></tr>
        </table>
        @if($b->items && $b->items->count())
            <table class="data">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="20%">Kategori</th>
                        <th>Item</th>
                        <th width="10%" class="text-right">Qty</th>
                        <th width="8%">Unit</th>
                        <th width="15%" class="text-right">Harga</th>
                        <th width="15%" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($b->items as $idx => $item)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $item->category ?? '-' }}</td>
                            <td>{{ $item->item_name }}</td>
                            <td class="text-right">{{ number_format($item->qty ?? 0, 2) }}</td>
                            <td>{{ $item->units ?? '-' }}</td>
                            <td class="text-right">{{ number_format($item->unit_cost ?? 0, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->total_cost ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        <div class="empty-state">Belum ada RAB untuk project ini.</div>
    @endif

    <div class="sub-title">Quotation / Penawaran</div>
    @if($project->latest_quotation)
        @php $q = $project->latest_quotation; @endphp
        <table class="info-table">
            <tr><td class="label" width="22%">Status</td><td class="sep">:</td><td>{{ $q->status ?? '-' }}</td></tr>
            <tr><td class="label">Total Nilai</td><td class="sep">:</td><td>Rp {{ number_format($q->total_project_value ?? 0, 0, ',', '.') }}</td></tr>
            <tr><td class="label">Harga Quotation</td><td class="sep">:</td><td>Rp {{ number_format($q->quotation_price ?? 0, 0, ',', '.') }}</td></tr>
            <tr><td class="label">Selling Price</td><td class="sep">:</td><td><strong>Rp {{ number_format($q->selling_price ?? 0, 0, ',', '.') }}</strong></td></tr>
            <tr><td class="label">Berlaku s/d</td><td class="sep">:</td><td>{{ $q->valid_until ? \Carbon\Carbon::parse($q->valid_until)->format('d M Y') : '-' }}</td></tr>
        </table>
        @if($q->items && $q->items->count())
            <table class="data">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Unit</th>
                        <th width="10%" class="text-right">Qty</th>
                        <th width="12%" class="text-right">Durasi</th>
                        <th width="15%" class="text-right">Rate</th>
                        <th width="18%" class="text-right">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($q->items as $idx => $item)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $item->unit_name }}</td>
                            <td class="text-right">{{ number_format($item->quantity ?? 0, 0) }}</td>
                            <td class="text-right">{{ $item->duration ?? '-' }} {{ $item->duration_unit ?? '' }}</td>
                            <td class="text-right">{{ number_format($item->rate ?? 0, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($item->total_price ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        <div class="empty-state">Belum ada Penawaran/Quotation.</div>
    @endif
</div>

{{-- ============================================================= --}}
{{-- NEGOSIASI & KONTRAK                                             --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">NEGOSIASI & KONTRAK</div>

    <div class="sub-title">Negosiasi</div>
    @if($project->latest_negotiation)
        @php $n = $project->latest_negotiation; @endphp
        <table class="info-table">
            <tr><td class="label" width="22%">No. Negosiasi</td><td class="sep">:</td><td>{{ $n->negotiation_number ?? '-' }}</td></tr>
            <tr><td class="label">Tanggal</td><td class="sep">:</td><td>{{ $n->negotiation_date ? \Carbon\Carbon::parse($n->negotiation_date)->format('d M Y') : '-' }}</td></tr>
            <tr><td class="label">Status</td><td class="sep">:</td><td>{{ $n->status ?? '-' }}</td></tr>
            <tr><td class="label">Penawaran Client</td><td class="sep">:</td><td>Rp {{ number_format($n->client_offer_value ?? 0, 0, ',', '.') }}</td></tr>
            <tr><td class="label">Penawaran Perusahaan</td><td class="sep">:</td><td>Rp {{ number_format($n->company_offer_value ?? 0, 0, ',', '.') }}</td></tr>
            <tr><td class="label">Final Disepakati</td><td class="sep">:</td><td><strong>Rp {{ number_format($n->final_agreed_value ?? 0, 0, ',', '.') }}</strong></td></tr>
        </table>
        @if($n->rounds && $n->rounds->count())
            <table class="data">
                <thead>
                    <tr>
                        <th width="8%">Round</th>
                        <th width="15%">Tanggal</th>
                        <th width="20%" class="text-right">Penawaran Client</th>
                        <th width="20%" class="text-right">Counter Perusahaan</th>
                        <th>Catatan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($n->rounds as $r)
                        <tr>
                            <td>{{ $r->round_number }}</td>
                            <td>{{ $r->meeting_date ? \Carbon\Carbon::parse($r->meeting_date)->format('d M Y') : '-' }}</td>
                            <td class="text-right">{{ number_format($r->client_offer_value ?? 0, 0, ',', '.') }}</td>
                            <td class="text-right">{{ number_format($r->company_counter_offer ?? 0, 0, ',', '.') }}</td>
                            <td>{{ $r->summary_notes ?? '-' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @else
        <div class="empty-state">Belum ada data negosiasi.</div>
    @endif

    <div class="sub-title">Kontrak Aktif</div>
    @if($project->contracts && $project->contracts->count())
        @foreach($project->contracts as $contract)
            <table class="info-table">
                <tr><td class="label" width="22%">No. Kontrak</td><td class="sep">:</td><td>{{ $contract->contract_number }}</td></tr>
                <tr><td class="label">Periode</td><td class="sep">:</td>
                    <td>
                        {{ $contract->start_date ? \Carbon\Carbon::parse($contract->start_date)->format('d M Y') : '-' }}
                        s/d
                        {{ $contract->end_date ? \Carbon\Carbon::parse($contract->end_date)->format('d M Y') : '-' }}
                    </td>
                </tr>
                <tr><td class="label">Status</td><td class="sep">:</td><td>{{ $contract->status->value ?? $contract->status }}</td></tr>
                @if($contract->attachment_path)
                <tr><td class="label">Lampiran</td><td class="sep">:</td><td><span class="text-muted">{{ basename($contract->attachment_path) }}</span></td></tr>
                @endif
            </table>
            @if($contract->items && $contract->items->count())
                <table class="data">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Unit</th>
                            <th width="10%">Kode</th>
                            <th width="8%" class="text-right">Qty</th>
                            <th width="12%" class="text-right">Durasi</th>
                            <th width="15%" class="text-right">Harga Satuan</th>
                            <th width="15%" class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($contract->items as $idx => $item)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $item->unit_name }}</td>
                                <td>{{ $item->equipment_code ?? '-' }}</td>
                                <td class="text-right">{{ number_format($item->qty ?? 0, 0) }}</td>
                                <td class="text-right">{{ $item->duration ?? '-' }} {{ $item->duration_unit ?? '' }}</td>
                                <td class="text-right">{{ number_format($item->unit_price ?? 0, 0, ',', '.') }}</td>
                                <td class="text-right">{{ number_format($item->total_price ?? 0, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @else
        <div class="empty-state">Belum ada kontrak aktif.</div>
    @endif
</div>

{{-- ============================================================= --}}
{{-- DEPLOYED UNITS (UNIT REQUEST)                                   --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">UNIT YANG DIKERAHKAN (DEPLOYED UNITS)</div>

    @forelse($unitRequests as $ur)
        <div class="avoid-break" style="margin-bottom: 14px;">
            <table class="info-table" style="background-color: #f9f9f9;">
                <tr>
                    <td class="label" width="20%">Request Number</td><td class="sep">:</td>
                    <td width="35%">
                        <strong>{{ $ur->request_number }}</strong>
                        @if($ur->isFromTransfer())
                            <span class="badge badge-warning" style="margin-left: 6px;">via Mutasi</span>
                        @endif
                    </td>
                    <td class="label" width="15%">Status</td><td class="sep">:</td>
                    <td>{{ $ur->status->value ?? $ur->status }}</td>
                </tr>
                <tr>
                    <td class="label">Tgl Request</td><td class="sep">:</td>
                    <td>{{ $ur->request_date ? \Carbon\Carbon::parse($ur->request_date)->format('d M Y') : '-' }}</td>
                    <td class="label">Mobilisasi</td><td class="sep">:</td>
                    <td>{{ $ur->mobilization_date ? \Carbon\Carbon::parse($ur->mobilization_date)->format('d M Y') : '-' }}</td>
                </tr>
                @if($ur->isFromTransfer() && $ur->sourceUnitTransfer)
                <tr>
                    <td class="label">Asal Mutasi</td><td class="sep">:</td>
                    <td colspan="4">
                        {{ $ur->sourceUnitTransfer->transfer_number }} —
                        {{ $ur->sourceUnitTransfer->sourceProject->project_number ?? '-' }} /
                        {{ $ur->sourceUnitTransfer->sourceUnitRequest->request_number ?? '-' }}
                    </td>
                </tr>
                @endif
                @if($ur->notes)
                <tr>
                    <td class="label">Catatan</td><td class="sep">:</td>
                    <td colspan="4">{{ $ur->notes }}</td>
                </tr>
                @endif
            </table>

            @if($ur->items && $ur->items->count())
                <table class="data">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Unit</th>
                            <th width="8%" class="text-right">Qty</th>
                            <th width="10%" class="text-right">Durasi</th>
                            <th width="18%">Operator</th>
                            <th>Status / Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ur->items as $idx => $item)
                            @php
                                $statusItem = [];
                                if ($item->replaced_by_item_id) $statusItem[] = 'Diganti';
                                if ($item->returned_qty > 0) $statusItem[] = 'Dikembalikan ' . $item->returned_qty;
                                if ($item->transferred_qty > 0) $statusItem[] = 'Ditransfer ' . $item->transferred_qty;
                                $remaining = ($item->qty ?? 0) - ($item->returned_qty ?? 0) - ($item->transferred_qty ?? 0);
                                if ($remaining > 0 && empty($statusItem)) $statusItem[] = 'Aktif';
                                elseif ($remaining > 0) $statusItem[] = 'Sisa Aktif ' . $remaining;
                            @endphp
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $item->unit_name }}</td>
                                <td class="text-right">{{ number_format($item->qty ?? 0, 0) }}</td>
                                <td class="text-right">{{ $item->duration_days ?? '-' }} hari</td>
                                <td>{{ $item->operator_name ?? '-' }}</td>
                                <td>{{ implode(', ', $statusItem) }}{{ $item->remarks ? ' — ' . $item->remarks : '' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    @empty
        <div class="empty-state">Belum ada unit yang dikerahkan.</div>
    @endforelse
</div>

{{-- ============================================================= --}}
{{-- PENGGANTIAN & PENGEMBALIAN UNIT                                 --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">PENGGANTIAN & PENGEMBALIAN UNIT</div>

    <div class="sub-title">Penggantian Unit (PTU)</div>
    @if($project->unitReplacements && $project->unitReplacements->count())
        @foreach($project->unitReplacements as $ptu)
            <table class="info-table avoid-break">
                <tr>
                    <td class="label" width="20%">No. PTU</td><td class="sep">:</td><td width="30%"><strong>{{ $ptu->replacement_number }}</strong></td>
                    <td class="label" width="15%">UR Terkait</td><td class="sep">:</td><td>{{ $ptu->unitRequest->request_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tgl Penggantian</td><td class="sep">:</td>
                    <td>{{ $ptu->replacement_date ? \Carbon\Carbon::parse($ptu->replacement_date)->format('d M Y') : '-' }}</td>
                    <td class="label">Status</td><td class="sep">:</td>
                    <td>{{ $ptu->status->value ?? $ptu->status }}</td>
                </tr>
                @if($ptu->cause)
                <tr><td class="label">Alasan</td><td class="sep">:</td><td colspan="4">{{ $ptu->cause }}</td></tr>
                @endif
            </table>
            @if($ptu->items && $ptu->items->count())
                <table class="data">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Unit Lama</th>
                            <th>Unit Pengganti</th>
                            <th width="8%" class="text-right">Qty</th>
                            <th width="18%">Operator</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ptu->items as $idx => $item)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $item->original_unit_name }} ({{ $item->original_equipment_code ?? '-' }})</td>
                                <td>{{ $item->replacement_unit_name }} ({{ $item->replacement_equipment_code ?? '-' }})</td>
                                <td class="text-right">{{ number_format($item->replacement_qty ?? 0, 0) }}</td>
                                <td>{{ $item->operator_name ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @else
        <div class="empty-state">Belum ada penggantian unit.</div>
    @endif

    <div class="sub-title">Pengembalian Unit (PPU)</div>
    @if($project->unitReturns && $project->unitReturns->count())
        @foreach($project->unitReturns as $ppu)
            <table class="info-table avoid-break">
                <tr>
                    <td class="label" width="20%">No. PPU</td><td class="sep">:</td><td width="30%"><strong>{{ $ppu->ppu_number }}</strong></td>
                    <td class="label" width="15%">UR Terkait</td><td class="sep">:</td><td>{{ $ppu->unitRequest->request_number ?? '-' }}</td>
                </tr>
                <tr>
                    <td class="label">Tgl Pengembalian</td><td class="sep">:</td>
                    <td>{{ $ppu->return_date ? \Carbon\Carbon::parse($ppu->return_date)->format('d M Y') : '-' }}</td>
                    <td class="label">Demobilisasi</td><td class="sep">:</td>
                    <td>{{ $ppu->demobilization_date ? \Carbon\Carbon::parse($ppu->demobilization_date)->format('d M Y') : '-' }}</td>
                </tr>
            </table>
            @if($ppu->items && $ppu->items->count())
                <table class="data">
                    <thead>
                        <tr>
                            <th width="5%">#</th>
                            <th>Unit</th>
                            <th width="10%">Kode</th>
                            <th width="8%" class="text-right">Qty</th>
                            <th width="18%">Operator</th>
                            <th>Catatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ppu->items as $idx => $item)
                            <tr>
                                <td>{{ $idx + 1 }}</td>
                                <td>{{ $item->unit_name }}</td>
                                <td>{{ $item->equipment_code ?? '-' }}</td>
                                <td class="text-right">{{ number_format($item->qty ?? 0, 0) }}</td>
                                <td>{{ $item->operator_name ?? '-' }}</td>
                                <td>{{ $item->notes ?? '-' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        @endforeach
    @else
        <div class="empty-state">Belum ada pengembalian unit.</div>
    @endif
</div>

{{-- ============================================================= --}}
{{-- HISTORY MUTASI UNIT                                             --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">HISTORY MUTASI UNIT</div>

    <div class="sub-title">Unit Masuk (dari project lain)</div>
    @if($unitMasuk->count())
        <table class="data">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="14%">No. UT</th>
                    <th width="12%">Tanggal</th>
                    <th width="22%">Asal Project</th>
                    <th>Unit</th>
                    <th width="8%" class="text-right">Qty</th>
                    <th width="15%">Operator</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unitMasuk as $ut)
                    @foreach($ut->items as $i => $item)
                        <tr>
                            @if($i === 0)
                                <td rowspan="{{ $ut->items->count() }}">{{ $loop->parent->iteration }}</td>
                                <td rowspan="{{ $ut->items->count() }}"><strong>{{ $ut->transfer_number }}</strong></td>
                                <td rowspan="{{ $ut->items->count() }}">{{ $ut->transfer_date ? \Carbon\Carbon::parse($ut->transfer_date)->format('d M Y') : '-' }}</td>
                                <td rowspan="{{ $ut->items->count() }}">
                                    {{ $ut->sourceProject->project_number ?? '-' }}<br>
                                    <small class="text-muted">{{ $ut->sourceProject->project_name ?? '' }}</small>
                                </td>
                            @endif
                            <td>{{ $item->unit_name }}{{ $item->equipment_code ? ' (' . $item->equipment_code . ')' : '' }}</td>
                            <td class="text-right">{{ number_format($item->qty ?? 0, 0) }}</td>
                            <td>{{ $item->operator_name ?? '-' }}</td>
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">Tidak ada unit masuk.</div>
    @endif

    <div class="sub-title">Unit Keluar (ke project lain)</div>
    @if($unitKeluar->count())
        <table class="data">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="14%">No. UT</th>
                    <th width="12%">Tanggal</th>
                    <th width="22%">Tujuan Project</th>
                    <th>Unit</th>
                    <th width="8%" class="text-right">Qty</th>
                    <th width="10%">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($unitKeluar as $ut)
                    @foreach($ut->items as $i => $item)
                        <tr>
                            @if($i === 0)
                                <td rowspan="{{ $ut->items->count() }}">{{ $loop->parent->iteration }}</td>
                                <td rowspan="{{ $ut->items->count() }}"><strong>{{ $ut->transfer_number }}</strong></td>
                                <td rowspan="{{ $ut->items->count() }}">{{ $ut->transfer_date ? \Carbon\Carbon::parse($ut->transfer_date)->format('d M Y') : '-' }}</td>
                                <td rowspan="{{ $ut->items->count() }}">
                                    {{ $ut->destinationProject->project_number ?? '-' }}<br>
                                    <small class="text-muted">{{ $ut->destinationProject->project_name ?? '' }}</small>
                                </td>
                            @endif
                            <td>{{ $item->unit_name }}{{ $item->equipment_code ? ' (' . $item->equipment_code . ')' : '' }}</td>
                            <td class="text-right">{{ number_format($item->qty ?? 0, 0) }}</td>
                            @if($i === 0)
                                <td rowspan="{{ $ut->items->count() }}">{{ $ut->status->value ?? $ut->status }}</td>
                            @endif
                        </tr>
                    @endforeach
                @endforeach
            </tbody>
        </table>
    @else
        <div class="empty-state">Tidak ada unit keluar.</div>
    @endif
</div>

{{-- ============================================================= --}}
{{-- TRACING UNIT                                                    --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">TRACING UNIT (Lifecycle per Unit)</div>

    @php
        $allItems = $unitRequests->flatMap->items;
    @endphp

    @forelse($allItems as $item)
        @php
            $ur = $item->unitRequest ?? $unitRequests->firstWhere('id', $item->unit_request_id);
            $remaining = ($item->qty ?? 0) - ($item->returned_qty ?? 0) - ($item->transferred_qty ?? 0);

            $statusBadge = 'Aktif';
            $badgeClass = 'badge-success';
            if ($item->replaced_by_item_id) {
                $statusBadge = 'Diganti';
                $badgeClass = 'badge-warning';
            } elseif ($remaining <= 0 && ($item->returned_qty > 0 && $item->transferred_qty == 0)) {
                $statusBadge = 'Dikembalikan';
                $badgeClass = 'badge-secondary';
            } elseif ($remaining <= 0 && ($item->transferred_qty > 0 && $item->returned_qty == 0)) {
                $statusBadge = 'Ditransfer';
                $badgeClass = 'badge-info';
            } elseif ($remaining <= 0) {
                $statusBadge = 'Selesai';
                $badgeClass = 'badge-secondary';
            } elseif ($remaining < ($item->qty ?? 0)) {
                $statusBadge = 'Sebagian Aktif';
                $badgeClass = 'badge-warning';
            }
        @endphp
        <div class="avoid-break" style="margin-bottom: 14px; border: 1px solid #ddd; border-radius: 4px; padding: 10px;">
            <div style="margin-bottom: 8px; padding-bottom: 6px; border-bottom: 1px solid #eee;">
                <strong style="font-size: 12px;">{{ $item->unit_name }}</strong>
                <span class="badge {{ $badgeClass }}" style="margin-left: 8px;">{{ $statusBadge }}</span>
                <span class="text-muted" style="float: right; font-size: 10px;">
                    Qty: {{ $item->qty ?? 0 }} | Sisa: {{ max($remaining, 0) }} | Operator: {{ $item->operator_name ?? '-' }}
                </span>
            </div>

            <table style="width: 100%; font-size: 10px;">
                @if($item->sourceUnitTransferItem)
                    @php $sut = $item->sourceUnitTransferItem->unitTransfer; @endphp
                    <tr>
                        <td width="3%" style="vertical-align: top;">●</td>
                        <td width="20%" class="text-muted">{{ $sut->transfer_date ? \Carbon\Carbon::parse($sut->transfer_date)->format('d M Y') : '-' }}</td>
                        <td><strong>Asal Mutasi</strong> — {{ $sut->transfer_number }}
                            <br><small class="text-muted">dari {{ $sut->sourceProject->project_number ?? '-' }} / {{ $sut->sourceUnitRequest->request_number ?? '-' }}</small>
                        </td>
                    </tr>
                @endif
                <tr>
                    <td style="vertical-align: top;">●</td>
                    <td class="text-muted">{{ $ur && $ur->request_date ? \Carbon\Carbon::parse($ur->request_date)->format('d M Y') : '-' }}</td>
                    <td><strong>Unit Request</strong> — {{ $ur->request_number ?? '-' }}
                        @if($ur && $ur->isFromTransfer())
                            <span class="badge badge-warning">via Mutasi</span>
                        @endif
                    </td>
                </tr>
                @if($item->replacedByItem && $item->replacedByItem->unitReplacement)
                    @php $rpl = $item->replacedByItem->unitReplacement; @endphp
                    <tr>
                        <td style="vertical-align: top;">●</td>
                        <td class="text-muted">{{ $rpl->replacement_date ? \Carbon\Carbon::parse($rpl->replacement_date)->format('d M Y') : '-' }}</td>
                        <td><strong>Penggantian (PTU)</strong> — {{ $rpl->replacement_number }}
                            <br><small class="text-muted">→ {{ $item->replacedByItem->replacement_unit_name ?? '-' }}</small>
                        </td>
                    </tr>
                @endif
                @foreach($item->returnItems ?? [] as $ri)
                    @php $ppu = $ri->unitReturn; @endphp
                    <tr>
                        <td style="vertical-align: top;">●</td>
                        <td class="text-muted">{{ $ppu && $ppu->return_date ? \Carbon\Carbon::parse($ppu->return_date)->format('d M Y') : '-' }}</td>
                        <td><strong>Pengembalian (PPU)</strong> — {{ $ppu->ppu_number ?? '-' }}
                            <small class="text-muted">(Qty {{ $ri->qty ?? 0 }})</small>
                        </td>
                    </tr>
                @endforeach
                @foreach($item->transferItems ?? [] as $ti)
                    @php $utr = $ti->unitTransfer; @endphp
                    <tr>
                        <td style="vertical-align: top;">●</td>
                        <td class="text-muted">{{ $utr && $utr->transfer_date ? \Carbon\Carbon::parse($utr->transfer_date)->format('d M Y') : '-' }}</td>
                        <td><strong>Mutasi Keluar (UT)</strong> — {{ $utr->transfer_number ?? '-' }}
                            <small class="text-muted">→ {{ $utr->destinationProject->project_number ?? '-' }} (Qty {{ $ti->qty ?? 0 }})</small>
                        </td>
                    </tr>
                @endforeach
                @if($remaining > 0 && !$item->replaced_by_item_id)
                    <tr>
                        <td style="vertical-align: top;">●</td>
                        <td class="text-muted">-</td>
                        <td><strong>Masih Aktif</strong> <small class="text-muted">(Qty {{ $remaining }})</small></td>
                    </tr>
                @endif
            </table>
        </div>
    @empty
        <div class="empty-state">Tidak ada unit untuk di-tracing.</div>
    @endforelse
</div>

{{-- ============================================================= --}}
{{-- WORK FORCE & UNIT FORMATION                                     --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">SK PENUGASAN TIM & PENETAPAN UNIT</div>

    <div class="sub-title">SK Penugasan Tim (Work Force)</div>
    @forelse($workforceFormations as $wf)
        <table class="info-table avoid-break">
            <tr>
                <td class="label" width="20%">No. SK</td><td class="sep">:</td><td width="30%"><strong>{{ $wf->formation_number }}</strong></td>
                <td class="label" width="15%">Status</td><td class="sep">:</td><td>{{ $wf->status->value ?? $wf->status }}</td>
            </tr>
            <tr>
                <td class="label">Efektif</td><td class="sep">:</td>
                <td>{{ $wf->effective_date ? \Carbon\Carbon::parse($wf->effective_date)->format('d M Y') : '-' }}</td>
                <td class="label">Berakhir</td><td class="sep">:</td>
                <td>{{ $wf->end_date ? \Carbon\Carbon::parse($wf->end_date)->format('d M Y') : '-' }}</td>
            </tr>
            <tr>
                <td class="label">Kontrak</td><td class="sep">:</td>
                <td colspan="4">{{ $wf->contract->contract_number ?? '-' }}</td>
            </tr>
        </table>
        @if($wf->members && $wf->members->count())
            <table class="data">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th width="25%">Jabatan</th>
                        <th>Nama Karyawan</th>
                        <th width="12%">Shift</th>
                        <th width="15%" class="text-right">Tarif Harian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($wf->members as $idx => $m)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $m->position_name }}</td>
                            <td>{{ $m->employee_name }}</td>
                            <td>{{ $m->shift ?? '-' }}</td>
                            <td class="text-right">{{ number_format($m->daily_rate ?? 0, 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @empty
        <div class="empty-state">Belum ada SK Penugasan Tim aktif.</div>
    @endforelse

    <div class="sub-title">SK Penetapan Unit</div>
    @forelse($unitFormations as $uf)
        <table class="info-table avoid-break">
            <tr>
                <td class="label" width="20%">No. SK</td><td class="sep">:</td><td width="30%"><strong>{{ $uf->formation_number }}</strong></td>
                <td class="label" width="15%">Status</td><td class="sep">:</td><td>{{ $uf->status->value ?? $uf->status }}</td>
            </tr>
            <tr>
                <td class="label">Efektif</td><td class="sep">:</td>
                <td>{{ $uf->effective_date ? \Carbon\Carbon::parse($uf->effective_date)->format('d M Y') : '-' }}</td>
                <td class="label">Berakhir</td><td class="sep">:</td>
                <td>{{ $uf->end_date ? \Carbon\Carbon::parse($uf->end_date)->format('d M Y') : '-' }}</td>
            </tr>
        </table>
        @if($uf->items && $uf->items->count())
            <table class="data">
                <thead>
                    <tr>
                        <th width="5%">#</th>
                        <th>Unit</th>
                        <th width="12%">Kode</th>
                        <th>Operator</th>
                        <th width="12%" class="text-right">HM Start</th>
                        <th width="14%" class="text-right">HM Target/Bln</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($uf->items as $idx => $item)
                        <tr>
                            <td>{{ $idx + 1 }}</td>
                            <td>{{ $item->unit_name }}</td>
                            <td>{{ $item->equipment_code ?? '-' }}</td>
                            <td>{{ $item->operator_name ?? '-' }}</td>
                            <td class="text-right">{{ number_format($item->hm_start ?? 0, 1) }}</td>
                            <td class="text-right">{{ number_format($item->hm_target_monthly ?? 0, 1) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    @empty
        <div class="empty-state">Belum ada SK Penetapan Unit aktif.</div>
    @endforelse
</div>

{{-- ============================================================= --}}
{{-- LAMPIRAN EVIDENCE INDEX                                         --}}
{{-- ============================================================= --}}
<div class="page-break"></div>
<div class="section">
    <div class="section-title">LAMPIRAN — DAFTAR FILE EVIDENCE</div>

    @php
        $evidence = collect();
        if ($latestSurvey && ($latestSurvey->documents ?? collect())->count()) {
            foreach ($latestSurvey->documents as $doc) {
                $evidence->push(['section' => 'Survey', 'name' => $doc->document_name ?? basename($doc->document_path), 'date' => $doc->created_at?->format('d M Y')]);
            }
        }
        foreach ($project->contracts ?? [] as $c) {
            if ($c->attachment_path) $evidence->push(['section' => 'Kontrak ' . $c->contract_number, 'name' => basename($c->attachment_path), 'date' => $c->created_at?->format('d M Y')]);
        }
        foreach ($unitRequests as $ur) {
            if ($ur->attachment_path) $evidence->push(['section' => 'UR ' . $ur->request_number, 'name' => basename($ur->attachment_path), 'date' => $ur->created_at?->format('d M Y')]);
        }
        foreach ($project->unitReplacements ?? [] as $ptu) {
            if ($ptu->attachment_path) $evidence->push(['section' => 'PTU ' . $ptu->replacement_number, 'name' => basename($ptu->attachment_path), 'date' => $ptu->created_at?->format('d M Y')]);
        }
        foreach ($project->unitReturns ?? [] as $ppu) {
            if ($ppu->attachment_path) $evidence->push(['section' => 'PPU ' . $ppu->ppu_number, 'name' => basename($ppu->attachment_path), 'date' => $ppu->created_at?->format('d M Y')]);
        }
        foreach ($unitMasuk as $ut) {
            if ($ut->attachment_path) $evidence->push(['section' => 'UT Masuk ' . $ut->transfer_number, 'name' => basename($ut->attachment_path), 'date' => $ut->created_at?->format('d M Y')]);
        }
        foreach ($unitKeluar as $ut) {
            if ($ut->attachment_path) $evidence->push(['section' => 'UT Keluar ' . $ut->transfer_number, 'name' => basename($ut->attachment_path), 'date' => $ut->created_at?->format('d M Y')]);
        }
        foreach ($workforceFormations as $wf) {
            if ($wf->attachment_path) $evidence->push(['section' => 'SK Tim ' . $wf->formation_number, 'name' => basename($wf->attachment_path), 'date' => $wf->created_at?->format('d M Y')]);
        }
        foreach ($unitFormations as $uf) {
            if ($uf->attachment_path) $evidence->push(['section' => 'SK Unit ' . $uf->formation_number, 'name' => basename($uf->attachment_path), 'date' => $uf->created_at?->format('d M Y')]);
        }
    @endphp

    @if($evidence->count())
        <table class="data">
            <thead>
                <tr>
                    <th width="5%">#</th>
                    <th width="30%">Bagian</th>
                    <th>Nama File</th>
                    <th width="15%">Tanggal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($evidence as $idx => $ev)
                    <tr>
                        <td>{{ $idx + 1 }}</td>
                        <td>{{ $ev['section'] }}</td>
                        <td>{{ $ev['name'] }}</td>
                        <td>{{ $ev['date'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <p class="text-muted" style="font-size: 9px; margin-top: 8px;">
            Catatan: file evidence tersimpan di sistem dan dapat diakses melalui modul masing-masing.
        </p>
    @else
        <div class="empty-state">Tidak ada file evidence yang dilampirkan.</div>
    @endif
</div>

<div style="margin-top: 30px; text-align: center; font-size: 9px; color: #888;">
    Generated by SSB Project Management System &bull; {{ now()->format('d M Y H:i') }}
</div>

</body>
</html>
