<!DOCTYPE html>
<html>
<head>
    <title>Survey Report - {{ $survey->project->project_name ?? '-' }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 2px solid #000; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin-bottom: 5px; }
        .subtitle { font-size: 14px; color: #555; }
        .info-table { width: 100%; margin-bottom: 20px; }
        .info-table td { padding: 4px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table th, .table td { border: 1px solid #ddd; padding: 8px; text-align: left; }
        .table th { background-color: #f2f2f2; font-weight: bold; }
        .notes-box { border: 1px solid #ddd; padding: 10px; min-height: 60px; background-color: #f9f9f9; }
        .footer { margin-top: 40px; font-size: 10px; text-align: center; color: #777; }
        .page-break { page-break-after: always; }
        .dept-header { 
            background-color: #2c3e50; 
            color: #fff; 
            padding: 10px 15px; 
            font-size: 16px; 
            font-weight: bold; 
            margin-bottom: 15px;
            border-radius: 4px;
        }
        .summary-card {
            border: 1px solid #ddd;
            border-radius: 4px;
            padding: 12px;
            margin-bottom: 10px;
        }
        .score-feasible { color: #27ae60; font-weight: bold; }
        .score-not-feasible { color: #e74c3c; font-weight: bold; }
        .badge-feasible { 
            background-color: #27ae60; 
            color: #fff; 
            padding: 3px 10px; 
            border-radius: 3px; 
            font-size: 11px; 
        }
        .badge-not-feasible { 
            background-color: #e74c3c; 
            color: #fff; 
            padding: 3px 10px; 
            border-radius: 3px; 
            font-size: 11px; 
        }
    </style>
</head>
<body>

    {{-- ==================== COVER / SUMMARY PAGE ==================== --}}
    <div class="header">
        <div class="title">PROJECT FEASIBILITY SURVEY REPORT</div>
        <div class="subtitle">All Department Assessments</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="15%"><strong>Project Name</strong></td>
            <td width="35%">: {{ $survey->project->project_name ?? '-' }}</td>
            <td width="15%"><strong>Survey Code</strong></td>
            <td width="35%">: {{ substr($survey->uid, 0, 8) }}...</td>
        </tr>
        <tr>
            <td><strong>Project Code</strong></td>
            <td>: {{ $survey->project->project_code ?? '-' }}</td>
            <td><strong>Status</strong></td>
            <td>: {{ str_replace('_', ' ', $survey->status) }}</td>
        </tr>
        <tr>
            <td><strong>Scheduled At</strong></td>
            <td>: {{ $survey->scheduled_at ? $survey->scheduled_at->format('d M Y H:i') : '-' }}</td>
            <td><strong>Total Score</strong></td>
            <td>: 
                @if($survey->total_score !== null)
                    <strong>{{ number_format($survey->total_score, 2) }}</strong>
                @else
                    -
                @endif
            </td>
        </tr>
        <tr>
            <td><strong>Feasibility</strong></td>
            <td colspan="3">: 
                @if($survey->total_score !== null)
                    @if($survey->is_feasible)
                        <span class="badge-feasible">FEASIBLE</span>
                    @else
                        <span class="badge-not-feasible">NOT FEASIBLE</span>
                    @endif
                @else
                    -
                @endif
            </td>
        </tr>
    </table>

    {{-- Department Summary Table --}}
    <h4 style="margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Department Score Summary</h4>
    <table class="table">
        <thead>
            <tr>
                <th width="5%">No</th>
                <th width="25%">Department</th>
                <th width="15%">Score</th>
                <th width="15%">Weight</th>
                <th width="15%">Weighted Score</th>
                <th width="25%">Evaluator</th>
            </tr>
        </thead>
        <tbody>
            @forelse($scores as $index => $score)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $score->department }}</td>
                <td>{{ number_format($score->score, 2) }}%</td>
                <td>{{ number_format($score->weight, 0) }}%</td>
                <td><strong>{{ number_format($score->weighted_score, 2) }}</strong></td>
                <td>{{ $score->submitter->name ?? '-' }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center;">No department scores recorded.</td>
            </tr>
            @endforelse
        </tbody>
        @if($scores->count() > 0)
        <tfoot>
            <tr style="background-color: #f2f2f2;">
                <td colspan="4" style="text-align: right; font-weight: bold;">Total Weighted Score:</td>
                <td colspan="2" style="font-weight: bold; color: #007bff;">{{ number_format($survey->total_score, 2) }}</td>
            </tr>
        </tfoot>
        @endif
    </table>

    @if($scores->count() > 0)
    <div class="page-break"></div>
    @endif

    {{-- ==================== DETAIL PER DEPARTMENT ==================== --}}
    @foreach($scores as $deptIndex => $score)
        <div class="dept-header">{{ $score->department }} DEPARTMENT ASSESSMENT</div>

        <table class="info-table">
            <tr>
                <td width="15%"><strong>Evaluator</strong></td>
                <td width="35%">: {{ $score->submitter->name ?? '-' }}</td>
                <td width="15%"><strong>Score</strong></td>
                <td width="35%">: {{ number_format($score->score, 2) }} / 100</td>
            </tr>
            <tr>
                <td><strong>Date Submitted</strong></td>
                <td>: {{ $score->created_at->format('d M Y H:i') }}</td>
                <td><strong>Weight</strong></td>
                <td>: {{ number_format($score->weight, 0) }}%</td>
            </tr>
            <tr>
                <td><strong>Weighted Score</strong></td>
                <td colspan="3">: <strong style="color: #007bff;">{{ number_format($score->weighted_score, 2) }}</strong></td>
            </tr>
        </table>

        <div style="margin-top: 15px;">
            <h4 style="margin-bottom: 10px; border-bottom: 1px solid #ccc; padding-bottom: 5px;">Detailed Assessment Criteria</h4>
            
            @forelse($score->criteria as $index => $crit)
            @php
                $masterCriteria = \App\Models\ScoringCriteria::with('options')->where('name', $crit->criterion_name)->first();
            @endphp
            <div style="margin-bottom: 15px; border: 1px solid #ddd; border-radius: 4px; padding: 10px; page-break-inside: avoid;">
                <div style="font-weight: bold; background-color: #f2f2f2; padding: 6px; margin-bottom: 8px;">
                    {{ $index + 1 }}. {{ $crit->criterion_name }}
                    <span style="float: right; font-weight: normal; font-size: 11px;">Weight: {{ $masterCriteria->weighting ?? '-' }}</span>
                </div>
                
                @if($masterCriteria && $masterCriteria->options->count() > 0)
                    <table style="width: 100%; border-collapse: collapse;">
                        @foreach($masterCriteria->options as $opt)
                            @php
                                $isSelected = ($crit->justification == ($opt->label . ' (' . $opt->score . ' pts)'));
                            @endphp
                            <tr>
                                <td width="3%" style="vertical-align: top; padding: 6px 4px;">
                                    <div style="width: 12px; height: 12px; border: 1px solid #000; border-radius: 2px; text-align: center; line-height: 12px; display: inline-block;">
                                        {!! $isSelected ? '&#10003;' : '&nbsp;' !!}
                                    </div>
                                </td>
                                <td width="82%" style="vertical-align: top; padding: 4px;">
                                    <strong style="{{ $isSelected ? 'color: #000;' : 'color: #777;' }}">{{ $opt->label }}</strong><br>
                                    <span style="font-size: 10px; {{ $isSelected ? 'color: #333;' : 'color: #999;' }}">{{ $opt->description }}</span>
                                </td>
                                <td width="15%" style="vertical-align: top; padding: 4px; text-align: right; {{ $isSelected ? 'font-weight: bold;' : 'color: #777;' }}">
                                    {{ $opt->score }} pts
                                </td>
                            </tr>
                        @endforeach
                    </table>
                @else
                    <p style="padding: 0 10px;"><strong>Selected:</strong> {{ $crit->justification }} ({{ floatval($crit->score) }} pts)</p>
                @endif
            </div>
            @empty
                <div style="text-align: center; padding: 20px; border: 1px solid #ddd;">No detailed criteria recorded.</div>
            @endforelse
        </div>

        <table class="table" style="margin-top: 15px; width: 50%; float: right;">
            <tbody>
                <tr>
                    <th style="text-align: left;">Percentage Score:</th>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($score->score, 1) }}%</td>
                </tr>
                <tr>
                    <th style="text-align: left;">Weight Contribution:</th>
                    <td style="text-align: right; font-weight: bold;">{{ number_format($score->weight, 0) }}%</td>
                </tr>
                <tr style="background-color: #f2f2f2;">
                    <th style="text-align: left;">Weighted Score:</th>
                    <td style="text-align: right; font-weight: bold; color: #007bff;">{{ number_format($score->weighted_score, 2) }}</td>
                </tr>
            </tbody>
        </table>
        <div style="clear: both;"></div>

        <div style="margin-top: 15px;">
            <h4 style="margin-bottom: 5px;">Assessment Notes</h4>
            <div class="notes-box">
                {!! nl2br(e($score->notes)) !!}
            </div>
        </div>

        {{-- Page break between departments, except after the last one --}}
        @if(!$loop->last)
        <div class="page-break"></div>
        @endif
    @endforeach

    <div class="footer">
        Generated by SSB Project Management System &bull; {{ date('d M Y H:i') }}
    </div>

</body>
</html>
