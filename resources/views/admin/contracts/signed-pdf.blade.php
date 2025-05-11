<!-- resources/views/contracts/signed-pdf.blade.php -->
<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Contract #{{ $contract->id }}</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; }
        .signature { height: 80px; }
        .footer { margin-top: 50px; }
    </style>
</head>
<body>
    <h1>{{ $contract->title }}</h1>
    
    <div class="content">
        {!! $contract->content !!}
    </div>
    
    <div class="footer">
        <table width="100%">
            <tr>
                <td width="50%">
                    <strong>Client Signature</strong><br>
                    <img src="{{ $contract->signature_data ?? 'n/a' }}" class="signature">
                </td>
                <td width="50%">
                    <strong>Date Signed</strong><br>
                    {{ optional($contract->party_signed_at)->format('M j, Y') ?? 'n/a' }}
                </td>
            </tr>
        </table>
    </div>
</body>
</html>