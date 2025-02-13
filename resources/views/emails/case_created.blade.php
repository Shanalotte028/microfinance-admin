@component('mail::message')
# You have been assigned to a new case

A new legal case has been assigned to you with the following details:

Case Number: {{ $caseNumber }}
Title: {{ $title }}
Created At: {{ $createdAt->format('Y-m-d H:i:s') }}

Thanks,<br>
Microfinance Solution Support Team
@endcomponent