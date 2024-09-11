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
                            <div>
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
                                            <td class="col-2">Created</td>
                                            <td class="col-5">{{ $client->created_at }}</td>
                                        </tr>
                                        <tr>
                                            <td class="col-2">Document Status</td>
                                            <td class="col-5">{{ $client->compliance->document_status}}</td>
                                        </tr>
                                        <tr>
                                            <td class="col-2">Audit Status</td>
                                            <td class="col-5">{{ $client->compliance->audit_status }}</td>
                                        </tr>
                                        <tr>
                                            <td class="col-2">Recommendation</td>
                                            <td class="col-5">{{ $client->risk->recommendation }}</td>
                                        </tr>
                                        <tr>
                                            <td class="col-2">Risk Score</td>
                                            <td class="col-5">{{ $client->risk->risk_score }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <!-- Right Column -->
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">
                            <h1>Compliance</h1>
                        </div>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="col-md-6">
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">
                            <h1>Risk Mitigation</h1>
                        </div>
                    </div>
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">
                            <h1>Transaction History</h1>
                        </div>
                    </div>
                    <div class="card bg-dark text-white mb-4">
                        <div class="card-body">
                            <h1>Loan History</h1>
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
