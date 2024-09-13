<x-header/>
<x-nav-bar/>
<x-nav-side/>
<div id="layoutSidenav_content" class="bg-dark" style="--bs-bg-opacity: .95;">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4 text-light">Client Overview</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active text-light">{{ $client->first_name }} {{ $client->last_name}}</li>
            </ol>
            <div class="row">
                <!-- Left Column -->
                <div class="col-md-6">
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">
                            <h4 class="text-light">{{ $client->email }}</h4>
                            <h5 class="text-light mb-4">User ID: {{ $client->id }}</h5>
                            <table class="table table-striped table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="col-2">Name</td>
                                        <td class="col-5">{{ $client->first_name }} {{ $client->last_name}}</td>
                                    </tr>
                                    <tr class="mt-3">
                                        <td class="col-2">Email</td>
                                        <td class="col-5">{{ $client->email }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Phone Number</td>
                                        <td class="col-5">{{ $client->phone_number }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Birthday</td>
                                        <td class="col-5">{{ $client->birthday }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Gender</td>
                                        <td class="col-5">{{ $client->gender }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Client Type</td>
                                        <td class="col-5">{{ $client->client_type }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Client Status</td>
                                        <td class="col-5">{{ $client->client_status }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Created</td>
                                        <td class="col-5">{{ $client->created_at }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Address Line 1</td>
                                        <td class="col-5">{{ $client->addresses->first()->address_line_1 }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Address Line 2</td>
                                        <td class="col-5">{{ $client->addresses->first()->address_line_2 }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">City</td>
                                        <td class="col-5">{{ $client->addresses->first()->city }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Province</td>
                                        <td class="col-5">{{ $client->addresses->first()->province }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Postal Code</td>
                                        <td class="col-5">{{ $client->addresses->first()->postal_code }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    
                    <!-- Compliance Records Card -->
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body table-responsive">
                            <h4 class="mb-4">Compliance Records</h4>
                            <table class="table table-striped table-borderless">
                                <thead>
                                    <tr>
                                        <th class="col-3">Document Type</th>
                                        <th class="col-3">Document Status</th>
                                        <th class="col-3">Submission Date</th>
                                        <th class="col-2">Approval Date </th>
                                        <th class="col-1">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($client->compliance_records->take(2) as $compliance)
                                        <tr>
                                            <td>{{ $compliance->document_type }}</td>
                                            <td>{{ $compliance->document_status }}</td>
                                            <td>{{ $compliance->submission_date }}</td>
                                            <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                                            <td>
                                                <a href="{{ url('clients/'.$client->id.'/compliance-records/'.$compliance->id) }}" class="btn btn-success">View</a> <!-- View button -->
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <div class="text-end mt-4 pe-4">
                                <a href="{{ url('clients/'.$client->id.'/compliance-records')}}" class="btn btn-success">Show All</a> <!-- Show all button -->
                            </div> 
                        </div>
                    </div>
                </div>
                
                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">
                            <h1 class="mb-4">Risk Mitigation</h1>
                        </div>
                    </div>
                    {{-- Financial Card --}}
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">
                            <h1 class="mb-4">Financial Details</h1>
                            <table class="table table-striped table-borderless">
                                <tbody>
                                    <tr>
                                        <td class="col-2">Total amount borrowed</td>
                                        <td class="col-5">{{ $client->financial_details->total_loan_amount_borrowed }}</td>
                                    </tr>
                                    <tr class="mt-3">
                                        <td class="col-2">Repayment Status</td>
                                        <td class="col-5">{{ $client->financial_details->loan_repayment_status  }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Income</td>
                                        <td class="col-5">{{ $client->financial_details->income }}</td>
                                    </tr>
                                    <tr>
                                        <td class="col-2">Credit Score</td>
                                        <td class="col-5">{{ $client->financial_details->credit_score  }}</td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="text-end mt-4 pe-4">
                                <a href="{{ url('clients/'.$client->id.'/financial-details/'.$client->financial_details->id)}}" class="btn btn-success">Show Loans</a> <!-- Show all button -->
                            </div> 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <x-footer/>
</div>
<x-foot/>
