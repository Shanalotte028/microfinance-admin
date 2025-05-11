@component('mail::message')
# Contract: {{ $contract->title ?? 'Untitled Contract' }}

Dear {{ $recipient->first_name }},

Please sign your contract by clicking the button below:

@component('mail::button', ['url' => $url])
Sign Contract Now
@endcomponent

This link expires on **{{ $expiry }}**.

Thanks,  
{{ config('app.name') }}
@endcomponent
