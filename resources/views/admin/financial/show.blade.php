<x-admin.dashboard-layout>
    <x-slot:heading>
        Financial Details
    </x-slot:heading>
        <div class="row">
            <div class="col-md-4"> {{-- left column --}}
                <x-admin.card-table-info>
                    <x-slot:heading>{{ $client->first_name }} {{ $client->last_name }}</x-slot:heading>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Total Amount Borrowed</x-slot:heading>
                            {{ $financial->total_loan_amount_borrowed }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Repayment Status</x-slot:heading>
                            {{ $financial->loan_repayment_status }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Income</x-slot:heading>
                            {{ $financial->income }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Credit Score</x-slot:heading>
                            {{ $financial->credit_score }}
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
                            <th>Start Date</th>
                            <th>End Date</th>
                            <th>Action</th>
                        </x-slot:table_row>
                            @foreach ($financial->loans as $loan)
                                <tr>
                                <td>{{ $loan->loan_amount }}</td>
                                <td>{{ $loan->loan_status }}</td>
                                <td>{{ $loan->interest_rate }}</td>
                                <td>{{ $loan->start_date }}</td>
                                <td>{{ $loan->end_date }}</td>
                                <td><a href="{{ url('admin/clients/'.$client->id.'/financial-details/'.$financial->id.'/loans/'.$loan->id) }}" class="btn btn-success">View</a></td>
                                </tr>
                            @endforeach
                </x-admin.card-table-list>
            </div>
        </div>
</x-admin.dashboard-layout>