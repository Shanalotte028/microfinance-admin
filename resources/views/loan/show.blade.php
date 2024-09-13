<x-header/>
    <x-nav-bar/>
    <x-nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                <h1 class="mt-4 text-light">{{ $client->first_name }} {{ $client->last_name }}</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body">
                                    <h4 class="mb-4">Loan Details</h4>
                                    <table class="table table-striped table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="col-2">Loan Amount</td>
                                                <td class="col-5">{{ $loan->loan_amount }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Loan Status</td>
                                                <td class="col-5">{{ $loan->loan_status }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Interest Rate</td>
                                                <td class="col-5">{{ $loan->interest_rate }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Start Date</td>
                                                <td>{{ $loan->start_date}}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">End Date</td>
                                                <td>{{ $loan->end_date}}</td>
                                            </tr>
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