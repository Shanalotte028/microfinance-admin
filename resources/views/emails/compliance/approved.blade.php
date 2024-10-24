@component('mail::message')
# Compliance Document Approved

Dear {{ $first_name }},

We are pleased to inform you that your {{ $compliance_type }}, {{ $document_type }} compliance document has been approved on {{ $approval_date }}.

If you have any questions, please contact our support team.

Thank you for staying compliant!

Best Regards,  
{{ config('app.name') }}
@endcomponent