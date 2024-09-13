<x-header/>
    <x-nav-bar/>
    <x-nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">Compliance Record</h1>
                    <div class="row">
                        <div class="col-md-4"> {{-- left column --}}
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body"> 
                                    <h4 class="mb-4">{{ $compliance->document_type }}</h4>
                                    <table class="table table-striped table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="col-2">Document Type</td>
                                                <td class="col-5">{{ $compliance->document_type }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Document Status</td>
                                                <td class="col-5">{{ $compliance->document_status }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Submission Date</td>
                                                <td class="col-5">{{ $compliance->submission_date }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Approval Date</td>
                                                <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Remarks</td>
                                                <td class="col-5">{{ $compliance->remarks }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8"> {{-- right column --}}
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body table-responsive"> 
                                    <h4 class="mb-4">KYC Records</h4>
                                    <table class="table table-striped table-borderless">
                                        <thead>
                                            <th>Document Type</th>
                                            <th>Verification Status</th>
                                            <th>Uploaded At</th>
                                            <th>Verified At</th>
                                            <th>Verified By</th>
                                            <th>Action</th>
                                        </thead>
                                        <tbody>
                                          @foreach ($compliance->kyc_records as $kyc)
                                              <tr>
                                                <td>{{ $kyc->document_type }}</td>
                                                <td>{{ $kyc->verification_status }}</td>
                                                <td>{{ $kyc->uploaded_at }}</td>
                                                <td>{{ $kyc->verified_at ?? 'n/a' }}</td>
                                                <td>{{ $kyc->verified_by ?? 'n/a' }}</td>
                                                <td><a href="{{ url('clients/'.$client->id.'/compliance-records/'.$compliance->id.'/kyc-records/'.$kyc->id) }}" class="btn btn-success">View</a></td>
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