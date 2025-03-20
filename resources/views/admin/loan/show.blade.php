<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.financial.show', ['client' => $client->id, 'financial'=>$financial->id]) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        {{ $client->first_name }} {{ $client->last_name }}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>Loan Details</x-slot:heading>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Term Type</x-slot:heading>
                        {{ $loan->term_type }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Loan Term</x-slot:heading>
                        {{ $loan->loan_term }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Payment Frequency Method</x-slot:heading>
                        {{ $loan->payment_frequency_method }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Principal Amount</x-slot:heading>
                        {{ $loan->principal_amount }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Loan Status</x-slot:heading>
                        {{ $loan->loan_status }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Interest Rate</x-slot:heading>
                        {{ $loan->interest_rate }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Installment</x-slot:heading>
                        {{ $loan->installment }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Loan Description</x-slot:heading>
                        {{ $loan->loan_description }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Submitted Date</x-slot:heading>
                        {{ $loan->submitted_at }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>End Date</x-slot:heading>
                        {{ $loan->end_date }}
                    </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>
        </div>
</x-admin.dashboard-layout>