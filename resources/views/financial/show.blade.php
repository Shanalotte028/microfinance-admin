<x-header/>
    <x-nav-bar/>
    <x-nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">Financial Details</h1>
                    <div class="row">
                        <div class="col-md-4"> {{-- left column --}}
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body"> 
                                    <h4 class="mb-4">{{ $client->first_name }} {{ $client->last_name }}</h4>
                                    <table class="table table-striped table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="col-2">Total amount borrowed</td>
                                                <td class="col-4">{{ $financial->total_loan_amount_borrowed }}</td>
                                            </tr>
                                            <tr class="mt-3">
                                                <td class="col-2">Repayment Status</td>
                                                <td class="col-5">{{ $financial->loan_repayment_status  }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Income</td>
                                                <td class="col-5">{{ $financial->income }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Credit Score</td>
                                                <td class="col-5">{{ $financial->credit_score  }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8"> {{-- right column --}}
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body table-responsive"> 
                                    <h4 class="mb-4">Loan Records</h4>
                                    <table class="table table-striped table-borderless">
                                        <thead>
                                            <th>Loan Amount</th>
                                            <th>Loan Status</th>
                                            <th>Interest Rate</th>
                                            <th>Start Date</th>
                                            <th>End Date</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                          @foreach ($financial->loans as $loan)
                                              <tr>
                                                <td>{{ $loan->loan_amount }}</td>
                                                <td>{{ $loan->loan_status }}</td>
                                                <td>{{ $loan->interest_rate }}</td>
                                                <td>{{ $loan->start_date }}</td>
                                                <td>{{ $loan->end_date }}</td>
                                                <td><a href="{{ url('clients/'.$client->id.'/financial-details/'.$financial->id.'/loans/'.$loan->id) }}" class="btn btn-success">View</a></td>
                                              </tr>
                                          @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <x-footer/>
        </div>
    </div>
<x-foot/>