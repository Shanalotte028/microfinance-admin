<x-header/>
    <x-nav-bar/>
    <x-nav-side/>
        <div id="layoutSidenav_content"  class="bg-dark" style="--bs-bg-opacity: .95;">
            <main>
                <div class="container-fluid px-4">
                    <h1 class="mt-4 text-light">{{ $kyc->document_type }}</h1>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body">
                                    <h4 class="mb-4"></h4>
                                    <table class="table table-striped table-borderless">
                                        <tbody>
                                            <tr>
                                                <td class="col-2">Document Type</td>
                                                <td class="col-5">{{ $kyc->document_type }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Verification Status</td>
                                                <td class="col-5">{{ $kyc->verification_status }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Submission Date</td>
                                                <td class="col-5">{{ $kyc->uploaded_at }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Verified At</td>
                                                <td>{{ $kyc->verfied_at ?? 'n/a' }}</td>
                                            </tr>
                                            <tr>
                                                <td class="col-2">Verified At</td>
                                                <td>{{ $kyc->verified_by ?? 'n/a' }}</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="card bg-dark text-white mb-4">
                                <div class="card-body">
                                    <h4 class="mb-4"></h4>
                                    <table class="table table-striped table-borderless">
                                        {{ $kyc->document_path }}
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