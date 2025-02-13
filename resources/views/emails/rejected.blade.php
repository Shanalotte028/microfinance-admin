@component('mail::message')
# Compliance Document Rejected

Dear {{ $clientName }},

Your compliance document for **{{ $documentType }}** has been rejected.

@if ($remarks)
**Remarks:**  
{{ $remarks }}
@endif

If you have any questions, please contact us.

Thanks,<br>
Microfinance Solution Support team
@endcomponent