<x-admin.dashboard-layout>
    <x-slot:heading>User Overview</x-slot:heading>
    <x-slot:heading_child>{{ $client->first_name }} {{ $client->last_name }}</x-slot:heading_child>
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <x-admin.card-table-info> {{-- Client Info Card --}}
                    <x-slot:heading>{{ $client->email }} <a class="btn btn-success" href="{{ url('admin/clients/'.$client->id.'/edit') }}">Edit Client</a></x-slot:heading>
                    <x-slot:heading_child>User ID: {{ $client->id }}</x-slot>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Name</x-slot:heading>
                            {{ $client->first_name }} {{ $client->last_name ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Email</x-slot:heading>
                            {{ $client->email ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Phone Number</x-slot:heading>
                            {{ $client->phone_number ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Birthday</x-slot:heading>
                            {{ $client->birthday ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Gender</x-slot:heading>
                            {{ $client->gender ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Nationality</x-slot:heading>
                            {{ $client->nationality ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Marital Status</x-slot:heading>
                            {{ $client->marital_status ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Source of Income</x-slot:heading>
                            {{ $client->source_of_income ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Tin Number</x-slot:heading>
                            {{ $client->tin_number ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client Type</x-slot:heading>
                            {{ $client->client_type ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Client Status</x-slot:heading>
                            {{ $client->client_status ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Created At</x-slot:heading>
                            {{ $client->created_at ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Address Line 1</x-slot:heading>
                            {{ $client->addresses->first()->address_line_1 ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Address Line 2</x-slot:heading>
                            {{ $client->addresses->first()->address_line_2 ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>City</x-slot:heading>
                            {{ $client->addresses->first()->city ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Province</x-slot:heading>
                            {{ $client->addresses->first()->province ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Postal Code</x-slot:heading>
                            {{ $client->addresses->first()->postal_code ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                </x-admin.card-table-info>        
                
                <!-- Compliance Records Card -->
                <x-admin.card-table-list>
                    <x-slot:heading>Compliance Record</x-slot:heading>
                    <x-slot:table_row>
                        <th class="col-3">Document Type</th>
                        <th class="col-3">Document Status</th>
                        <th class="col-3">Submission Date</th>
                        <th class="col-2">Approval Date </th>
                        <th class="col-1">Action</th>
                    </x-slot:table_row>
                    @foreach ($client->compliance_records->take(2) as $compliance)
                        <tr>
                            <td>{{ $compliance->document_type ?? 'n/a' }}</td>
                            <td>{{ $compliance->document_status ?? 'n/a' }}</td>
                            <td>{{ $compliance->submission_date ?? 'n/a' }}</td>
                            <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                            <td>
                                <a href="{{ url('/clients/'.$client->id.'/compliance-records/'.$compliance->id) }}" class="btn btn-success">View</a> <!-- View button -->
                            </td>
                        </tr>
                    @endforeach
                    <x-slot:button>
                        <a href="{{ url('/clients/'.$client->id.'/compliance-records')}}" class="btn btn-success">Show All</a>
                    </x-slot:button>
                </x-admin.card-table-list>
            </div>
            
            <!-- Right Column -->
            <div class="col-md-6">
                <div class="card bg-dark text-white mb-4"> {{-- Risk Mitigation --}}
                    <div class="card-body">
                        <h1 class="mb-4">Risk Mitigation</h1>
                    </div>
                </div>
                {{-- Financial Card --}}
                <x-admin.card-table-info>
                    <x-slot:heading>Financial Details</x-slot:heading>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Total Amount Borrowed</x-slot:heading>
                        {{ $client->financial_details->total_loan_amount_borrowed ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Repayment Status</x-slot:heading>
                        {{ $client->financial_details->loan_repayment_status ?? 'n/a'  }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Income</x-slot:heading>
                        {{ $client->financial_details->income ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Credit Score</x-slot:heading>
                        {{ $client->financial_details->credit_score ?? 'n/a'  }}
                    </x-admin.card-table-info-tr>
                    <x-slot:button>
                        @if(isset($client->financial_details) && isset($client->financial_details->id))
                            <a href="{{ url('/clients/'.$client->id.'/financial-details/'.$client->financial_details->id)}}" class="btn btn-success">Show Loans</a>
                        @endif
                    </x-slot:button>
                </x-admin.card-table-info>
            </div>
        </div>
        <x-client.success-popup/>
</x-admin.dashboard-layout>