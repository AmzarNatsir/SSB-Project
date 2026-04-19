<style>
    .compact-scoring-table th, .compact-scoring-table td {
        padding: 4px 8px !important;
        font-size: 13px;
        line-height: 1.2;
    }
    .compact-scoring-table .ps-4 {
        padding-left: 24px !important;
    }
</style>
<table class="table table-sm table-bordered mb-0 compact-scoring-table">
    <thead class="text-center align-middle">
        <tr>
            <th rowspan="2" style="width: 5%; background-color: #ffbc00 !important; color: #000 !important; border-color: #dcb325 !important;">NO</th>
            <th colspan="4" style="background-color: #ffbc00 !important; color: #000 !important; border-color: #dcb325 !important;">EVALUATION</th>
        </tr>
        <tr>
            <th style="width: 25%; background-color: #ffbc00 !important; color: #000 !important; border-color: #dcb325 !important;">Requirements</th>
            <th style="width: 10%; background-color: #ffbc00 !important; color: #000 !important; border-color: #dcb325 !important;">Available Score</th>
            <th style="width: 10%; background-color: #ffbc00 !important; color: #000 !important; border-color: #dcb325 !important;">Weighting</th>
            <th style="width: 50%; background-color: #ffbc00 !important; color: #000 !important; border-color: #dcb325 !important;">SCORE EXPLANATION</th>
        </tr>
    </thead>
    <tbody>
        @foreach($criteria as $index => $crit)
            @php $optionsCount = $crit->options->count(); @endphp
            @if($optionsCount > 0)
                <tr>
                    <td rowspan="{{ $optionsCount + 1 }}" class="text-center align-middle fw-bold" style="background-color: #fffaf0 !important;">{{ $index + 1 }}</td>
                    <td class="fw-bold" style="background-color: #fffaf0 !important;">{{ $crit->name }}</td>
                    <td style="background-color: #fffaf0 !important;"></td>
                    <td rowspan="{{ $optionsCount + 1 }}" class="text-center align-middle" style="background-color: #fffaf0 !important;">{{ $crit->weighting }}</td>
                    <td style="background-color: #fffaf0 !important;"></td>
                </tr>
                @foreach($crit->options as $option)
                <tr>
                    <td class="fst-italic ps-4">{{ $option->label }}</td>
                    <td class="text-center">{{ $option->score }}</td>
                    <td>{{ $option->description }}</td>
                </tr>
                @endforeach
            @endif
        @endforeach
        @if($criteria->isEmpty())
            <tr><td colspan="5" class="text-center">No Data Available</td></tr>
        @endif
    </tbody>
</table>
