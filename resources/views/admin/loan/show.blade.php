<x-admin.dashboard-layout>
    <x-slot:heading>
        {{ $client->first_name }} {{ $client->last_name }}
    </x-slot:heading>
        <div class="row">
            <div class="col-md-6">
                <x-admin.card-table-info>
                    <x-slot:heading>Loan Details</x-slot:heading>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Loan Amount</x-slot:heading>
                            {{ $loan->loan_amount }}
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
                            <x-slot:heading>Start Date</x-slot:heading>
                            {{ $loan->start_date }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>End Date</x-slot:heading>
                            {{ $loan->end_date }}
                        </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>
        </div>
</x-admin.dashboard-layout>