<!DOCTYPE html>
<html>
<head>
    <title>{{ $department }} Assessment - {{ $survey->project->project_name ?? '-' }}</title>
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
        .notes-box { border: 1px solid #ddd; padding: 10px; min-height: 80px; background-color: #f9f9f9; }
        .footer { margin-top: 40px; font-size: 10px; text-align: center; color: #777; }
    </style>
</head>
<body>

    <div class="header">
        <div class="title">{{ $department }} DEPARTMENT ASSESSMENT</div>
        <div class="subtitle">Project Feasibility Survey</div>
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
            <td><strong>Evaluator</strong></td>
            <td>: {{ $score->submitter->name ?? '-' }}</td>
        </tr>
        <tr>
            <td><strong>Date Submitted</strong></td>
            <td>: {{ $score->created_at->format('d M Y H:i') }}</td>
            <td><strong>Final Score</strong></td>
            <td>: {{ number_format($score->score, 2) }} / 100</td>
        </tr>
    </table>

    <div style="margin-top: 20px;">
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

    <table class="table" style="margin-top: 20px; width: 50%; float: right;">
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

    <div style="margin-top: 20px;">
        <h4 style="margin-bottom: 5px;">Assessment Notes</h4>
        <div class="notes-box">
            {!! nl2br(e($score->notes)) !!}
        </div>
    </div>

    <div class="footer">
        Generated by SSB Project Management System &bull; {{ date('d M Y H:i') }}
    </div>

</body>
</html>
