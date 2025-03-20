<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.client.show', ['client' => $client]) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Financial Details
    </x-slot:heading>
        <div class="row">
            <div class="col-md-4"> {{-- left column --}}
                <x-admin.card-table-info>
                    <x-slot:heading>{{ $client->first_name }} {{ $client->last_name }}</x-slot:heading>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Total Amount Borrowed</x-slot:heading>
                        {{ $client->financial_details->total_loan_amount_borrowed ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    {{-- <x-admin.card-table-info-tr>
                        <x-slot:heading>Repayment Status</x-slot:heading>
                        {{ $client->financial_details->loan_repayment_status ?? 'n/a'  }}
                    </x-admin.card-table-info-tr> --}}
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Annual Income</x-slot:heading>
                        {{ $client->financial_details->annual_income ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Monthly Income</x-slot:heading>
                        {{ $client->financial_details->monthly_income ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Savings Account Balance</x-slot:heading>
                        {{ $client->financial_details->savings_account_balance ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Checking Account Balance</x-slot:heading>
                        {{ $client->financial_details->checking_account_balance ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Total Assets</x-slot:heading>
                        {{ $client->financial_details->total_assets ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Networth</x-slot:heading>
                        {{ $client->financial_details->networth ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Credit Score</x-slot:heading>
                        {{ $client->financial_details->credit_score ?? 'n/a'  }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Late Payments</x-slot:heading>
                        {{ $client->financial_details->late_payments ?? 'n/a'  }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Loan Defaults</x-slot:heading>
                        {{ $client->financial_details->loan_defaults ?? 'n/a'  }}
                    </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
            </div>
            <div class="col-md-8"> {{-- right column --}}
                <x-admin.card-table-list>
                    <x-slot:heading>Loan Records</x-slot:heading>
                        <x-slot:table_row>
                            <th>Loan Amount</th>
                            <th>Loan Status</th>
                            <th>Interest Rate</th>
                            <th>Installment</th>
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </x-slot:table_row>
                            @foreach ($financial->loans as $loan)
                                <tr>
                                <td>{{ $loan->principal_amount }}</td>
                                <td>{{ $loan->loan_status }}</td>
                                <td>{{ $loan->interest_rate }}</td>
                                <td>{{ $loan->installment }}</td>
                                <td>{{ $loan->submitted_at }}</td>
                                <td>{{ $loan->end_date ?? 'n/a'}}</td>
                                <td><a href="{{ route('admin.loan.show', ['client'=>$client,'financial'=>$financial->id,'loan'=>$loan->id]) }}" class="btn btn-success">View</a></td>
                                </tr>
                            @endforeach
                </x-admin.card-table-list>
            </div>
        </div>
</x-admin.dashboard-layout>