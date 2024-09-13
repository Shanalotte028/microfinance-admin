<x-header/>
    <x-nav-bar/>
    <x-nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">Compliance Records</h1>
                    <div class="row">
                        <div class="card bg-dark text-white mb-4">
                            <div class="card-body table-responsive">
                                <h4 class="mb-4">Compliance Records</h4>
                                <table class="table table-striped table-borderless">
                                    <thead>
                                        <tr>
                                            <th>Document Type</th>
                                            <th>Document Status</th>
                                            <th>Submission Date</th>
                                            <th>Approval Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($client->compliance_records as $compliance)
                                            <tr>
                                                <td>{{ $compliance->document_type }}</td>
                                                <td>{{ $compliance->document_status }}</td>
                                                <td>{{ $compliance->submission_date }}</td>
                                                <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                                                <td>
                                                    <a href="{{ url('/clients/'.$client->id.'/compliance-records/'.$compliance->id) }}" class="btn btn-success">View</a> <!-- View button -->
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
            <x-footer/>
        </div>
    </div>
<x-foot/>