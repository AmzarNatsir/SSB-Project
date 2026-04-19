<!DOCTYPE html>
<html>
<head>
    <title>Scoring Plan Project</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 11px; }
        .table { width: 100%; border-collapse: collapse; margin-bottom: 1rem; }
        .table th, .table td { border: 1px solid #777; } /* Darker border for PDF printing */
        .text-center { text-align: center; }
        .align-middle { vertical-align: middle; }
        .fw-bold { font-weight: bold; }
        .fst-italic { font-style: italic; }
        
        .compact-scoring-table th, .compact-scoring-table td {
            padding: 4px 8px !important;
            font-size: 11px !important; /* Smaller for PDF */
            line-height: 1.2;
        }
        .compact-scoring-table .ps-4 {
            padding-left: 24px !important;
        }
        h2 { text-transform: uppercase; font-size: 16px; margin-top: 10px; }
        @page { margin: 30px; }
    </style>
</head>
<body>

    <h2 class="text-center fw-bold" style="margin-bottom: 20px;">SCORING PLAN PROJECT</h2>

    @include('reference.scoring_plan_project._full_view_table')

</body>
</html>
