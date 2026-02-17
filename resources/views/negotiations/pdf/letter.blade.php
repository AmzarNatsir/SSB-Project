<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Negotiation Agreement - {{ $negotiation->negotiation_number }}</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 30px; border-bottom: 1px solid #ddd; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; text-transform: uppercase; margin-bottom: 5px; }
        .meta { margin-bottom: 20px; }
        .meta table { width: 100%; }
        .meta td { padding: 5px; }
        .content { margin-bottom: 30px; line-height: 1.6; }
        .pricing-table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .pricing-table th, .pricing-table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        .pricing-table th { background-color: #f5f5f5; }
        .total-row td { font-weight: bold; background-color: #fafafa; }
        .signatures { width: 100%; margin-top: 50px; }
        .signatures td { width: 50%; vertical-align: top; }
        .sig-box { height: 80px; }
    </style>
</head>
<body>
    <div class="header">
        <div class="title">Price Negotiation Agreement</div>
        <div>Reference: {{ $negotiation->negotiation_number }}</div>
    </div>

    <div class="meta">
        <table>
            <tr>
                <td width="150"><strong>Date:</strong></td>
                <td>{{ $negotiation->negotiation_date->format('d F Y') }}</td>
            </tr>
             <tr>
                <td><strong>Project:</strong></td>
                <td>{{ $negotiation->project->project_name }} ({{ $negotiation->project->project_number }})</td>
            </tr>
            <tr>
                <td><strong>Client:</strong></td>
                <td>{{ $negotiation->project->customer_name ?? 'Client Name' }}</td>
            </tr>
            <tr>
                <td><strong>Original Quotation:</strong></td>
                <td>#{{ $negotiation->quotation->uid }} (Rp {{ number_format($negotiation->quotation->selling_price, 0, ',', '.') }})</td>
            </tr>
        </table>
    </div>

    <div class="content">
        <p>Following the negotiation meetings held between the Company and the Client, both parties have agreed to the final price structure as detailed below:</p>
        
        <table class="pricing-table">
            <thead>
                <tr>
                    <th>Description</th>
                    <th style="text-align: right;">Amount (IDR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Original Quoted Price</td>
                    <td style="text-align: right;">{{ number_format($negotiation->quotation->selling_price, 0, ',', '.') }}</td>
                </tr>
                <tr>
                    <td><strong>Final Agreed Price</strong></td>
                    <td style="text-align: right;"><strong>{{ number_format($negotiation->final_agreed_value, 0, ',', '.') }}</strong></td>
                </tr>
                <tr class="total-row">
                    <td>Difference (Discount/Adjustment)</td>
                    <td style="text-align: right;">
                        @php $diff = $negotiation->final_agreed_value - $negotiation->quotation->selling_price; @endphp
                        {{ $diff > 0 ? '+' : '' }}{{ number_format($diff, 0, ',', '.') }}
                    </td>
                </tr>
            </tbody>
        </table>
        
        <p><strong>Notes:</strong><br>
        {{ $negotiation->notes ?? 'No additional notes recorded.' }}</p>
        
        <p>This agreement serves as the basis for the formal contract generation. By signing below, both parties acknowledge the agreed value.</p>
    </div>

    <table class="signatures">
        <tr>
            <td>
                <strong>For and on behalf of Company:</strong><br>
                <div class="sig-box"></div>
                <br>
                Name: __________________________<br>
                Title: __________________________<br>
                Date: ___________________________
            </td>
            <td>
                <strong>For and on behalf of Client:</strong><br>
                <div class="sig-box"></div>
                <br>
                Name: __________________________<br>
                Title: __________________________<br>
                Date: ___________________________
            </td>
        </tr>
    </table>
</body>
</html>
