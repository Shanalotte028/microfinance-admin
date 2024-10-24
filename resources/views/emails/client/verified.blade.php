@component('mail::message')
# Account Verified

Dear {{ $clientName }},

Congratulations! Your account has been successfully verified. You now have full access to our platform.

If you need any assistance, feel free to reach out to us.

Best Regards,  
{{ config('app.name') }}
@endcomponent
