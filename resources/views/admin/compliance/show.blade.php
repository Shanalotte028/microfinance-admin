<x-admin.dashboard-layout>
    @include('components.admin.success-modal')
    <x-slot:back><a href="{{ route('admin.compliance.index', $client) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Compliance Record
    </x-slot:heading>
            <div class="row"> 
            {{-- Credit Investigation --}}
            <div class="col-md-6">
                @if(is_null($fieldInvestigation))
                <x-admin.card-table-info>
                    <x-slot:heading>Credit Investigation</x-slot:heading>
                    <x-slot:heading_child>No Field Investigator Assigned</x-slot:heading_child>
                    <form action="{{route('admin.investigation.assign')}}" method="POST">
                        @csrf
                        <div class="col-md-4 p-4">
                            <input type="hidden" name="client_id" value="{{$client->id}}">
                            <div class="form-group">
                                <select class="form-control" name="officer_id" id="officer_id" value="{{ old('officer_id') }}" required>
                                    <option value="" disabled selected class="text-dark">Assign Field Officer</option>
                                    @foreach ($field_officers as $field_officer)
                                    <option value="{{ $field_officer->id }}">{{ $field_officer->first_name }} {{ $field_officer->last_name }} </option>
                                    @endforeach
                                </select>
                                <x-admin.form-error name="officer_id"></x-admin.form-error>
                            </div>
                            <div class="mt-4 mb-0">
                                <div class="d-grid"><button class="btn btn-success btn-block" type="submit">Assign Field Officer</button></div>
                            </div>
                        </div>
                    </form>
                </x-admin.card-table-info>
                @else
                <x-admin.card-table-info>
                    <x-slot:heading>Credit Investigation</x-slot:heading>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Investigation ID</x-slot:heading>
                        <a href="{{ route('admin.investigation.show', ['client'=>$client, 'investigation'=>$fieldInvestigation->id])}}" class="text-light">{{ $fieldInvestigation->id }}</a>
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Client ID</x-slot:heading>
                        <a href="{{ route('admin.client.show', $client)}}" class="text-light">{{ $client->client_id }}</a>
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Officer ID</x-slot:heading>
                        <a href="{{ route('admin.user.show', $fieldInvestigation->officer_id)}}" class="text-light"> {{ $fieldInvestigation->officer_id ?? 'Unassigned' }} </a>
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Observations</x-slot:heading>
                        {{ $fieldInvestigation->observations ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Verified</x-slot:heading>
                        {{ $fieldInvestigation->verified ? 'Yes' : 'No' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Created At</x-slot:heading>
                        {{ $fieldInvestigation->created_at}}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Updated At</x-slot:heading>
                        {{ $fieldInvestigation->updated_at}}
                    </x-admin.card-table-info-tr>
                <x-slot:button>
                    @if(is_null($fieldInvestigation->officer_id))
                        <form action="{{ route('admin.investigation.assign') }}" method="POST">
                            @csrf
                            <div class="col-md-4 p-3">
                                <input type="hidden" name="client_id" value="{{ $client->id }}">
                                <div class="form-group">
                                    <select class="form-control" name="officer_id" id="officer_id" required>
                                        <option value="" disabled selected class="text-dark">Assign Field Officer</option>
                                        @foreach ($field_officers as $field_officer)
                                            <option value="{{ $field_officer->id }}">{{ $field_officer->first_name }} {{ $field_officer->last_name }}</option>
                                        @endforeach
                                    </select>
                                    <x-admin.form-error name="officer_id"></x-admin.form-error>
                                </div>
                                <div class="mt-4 mb-0">
                                    <div class="d-grid">
                                        <button class="btn btn-success btn-block" type="submit">Assign Field Officer</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    @endif
                </x-slot:button>
                </x-admin.card-table-info>
                @endif 
            </div>
            {{-- Risk Assessment --}}
            <div class="col-md-6">
                <div class="card bg-dark text-white mb-4"> {{-- Risk Mitigation --}}
                    <div class="card-body">
                        <div class="d-flex justify-content-between" >
                        <h4 class="mb-4">Risk Assessment</h4>
                            <div class="d-inline-block">
                                <a href="{{ route('admin.risk_assessment.index', $client) }}" class="btn btn-success ">List Risk</a>
                            </div> 
                        </div>
                        @php
                            $confidenceLevel = optional($client->risk_assessments()->latest('assessment_date')->first())->confidence_level ?? ''; 
                            $riskLevel = optional($client->risk_assessments()->latest('assessment_date')->first())->risk_level ?? '';

                            if($riskLevel === ''){
                                $riskCategory = '';
                                $bgClass = 'bg-light';
                                $textClass = 'text-light';
                            }else if ($riskLevel === 'High Risk') {
                                $riskCategory = 'High Risk';
                                $bgClass = 'bg-danger';
                                $textClass = 'text-danger';
                            } elseif ($riskLevel === 'Medium Risk') {
                                $riskCategory = 'Medium Risk';
                                $bgClass = 'bg-warning';
                                $textClass = 'text-warning';
                            } else{
                                $riskCategory = 'Low Risk';
                                $bgClass = 'bg-success';
                                $textClass = 'text-success';
                            }
                        @endphp
                        <h5 class=" text-center {{$textClass}}">Risk Level: {{ $riskLevel }}</h1>
                        <div class="progress" style="height: 35px; width: 100%; border-radius: 20px; position: relative;">
                            <div class="progress-bar {{ $bgClass }} d-flex align-items-center justify-content-center fw-bold"
                                role="progressbar" 
                                style="width: {{ $confidenceLevel }}%; min-width: 20%; max-width: 100%; white-space: nowrap; padding: 5px 10px;"
                                aria-valuenow="{{ $confidenceLevel }}" 
                                aria-valuemin="0" 
                                aria-valuemax="100">
                                Confidence Level: {{ $confidenceLevel }}%
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <p>Recent Assessment Date: {{ optional($client->risk_assessments()->latest('assessment_date')->first())->assessment_date ?? '' }}</p>
                            <form id="riskAssessmentForm"   method="POST" action="{{ route('api.risk_assessment.store', $client) }}">
                                @csrf
                                <button type="submit" class="btn btn-success" id="assessRiskButton">
                                    <span class="spinner-border spinner-border-sm d-none" id="assessRiskSpinner" role="status" aria-hidden="true"></span>
                                    <span id="assessRiskText">Assess Risk</span>
                                </button>   
                            </form>    
                        </div>
                    </div>
                </div>
            </div>
        
        {{-- Compliance Side --}}
        <h3 class="text-light p-3">Compliance Type: {{$complianceType}}</h3>
        @foreach($complianceRecords as $compliance) 
        <div class="row">
            {{-- compliance file column --}} 
            <div class="col-md-6 p-4">
                @if(is_null($complianceRecords))
                    <p>No KYC documents available.</p>
                @else
                    <x-admin.card-table-info>
                        <x-slot:heading>{{ $compliance->document_type }}</x-slot:heading>
                        @php
                            $fileExtension = pathinfo($compliance->document_path, PATHINFO_EXTENSION); // Get the file extension
                        @endphp
                        @if(in_array($fileExtension, ['jpg', 'jpeg', 'png']))
                            <!-- Display images -->
                            <img src="{{ Storage::url($compliance->document_path) }}" class="img-fluid" loading="lazy">
                        @elseif($fileExtension === 'pdf')
                            <!-- Display PDFs -->
                            <div id="pdf-viewer-{{ $compliance->id }}" style="width: 100%; height: 600px; overflow: auto;"></div>
                            <script>
                                document.addEventListener("DOMContentLoaded", function () {
                                    const url = '{{ Storage::url($compliance->document_path) }}';
                                    const pdfViewer = document.getElementById('pdf-viewer-{{ $compliance->id }}');
            
                                    // Asynchronously download PDF
                                    pdfjsLib.getDocument(url).promise.then(pdf => {
                                        const scale = 1; // Adjust scale to your preference
                                        pdf.getPage(1).then(page => {
                                            const viewport = page.getViewport({ scale });
            
                                            // Prepare canvas using PDF page dimensions
                                            const canvas = document.createElement('canvas');
                                            const context = canvas.getContext('2d');
                                            canvas.height = viewport.height;
                                            canvas.width = viewport.width;
                                            pdfViewer.appendChild(canvas);
            
                                            // Render PDF page into canvas context
                                            const renderContext = {
                                                canvasContext: context,
                                                viewport: viewport,
                                            };
                                            page.render(renderContext);
                                        });
                                    }).catch(function(error) {
                                        console.error("Error loading PDF: ", error);
                                        pdfViewer.innerHTML = '<p>Unable to load PDF. <a href="' + url + '" download>Download instead</a>.</p>';
                                    });
                                });
                            </script>
                        @else
                            <!-- Display download link for unsupported file types -->
                            <a href="{{ Storage::url($compliance->document_path) }}" download>Download {{ ucfirst($compliance->document_type) }}</a>
                        @endif
            
                        <!-- ✅ Download Button (Visible for all file types) -->
                        <div class="mt-3">
                            @php
                            $url = Storage::url($compliance->document_path);
                            @endphp
                            <a href="{{ url($url) }}" 
                               class="btn btn-primary" download>
                                <i class="bi bi-download"></i> Download {{ ucfirst($compliance->document_type) }}
                            </a>
                        </div>
                    </x-admin.card-table-info>
                @endif
            </div>

            {{-- compliance info column --}} 
            <div class="col-md-6 p-4">
                @if(is_null($compliance))
                    <p>No KYC documents available.</p>
                @else
                        <x-admin.card-table-info>
                            <x-slot:heading>{{ $compliance->compliance_type }}</x-slot:heading>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Compliance Record ID</x-slot:heading>
                                {{ $compliance->id }}
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Client ID</x-slot:heading>
                            <a href="{{ route('admin.client.show', $client->client_id)}}" class="text-light">{{ $client->client_id }}</a> 
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Client Email</x-slot:heading>
                                <a href="{{ route('admin.client.show', $client->client_id)}}" class="text-light"> {{ $client->email }} </a>
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Compliance Type</x-slot:heading>
                                {{ $compliance->compliance_type }}
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Document Type</x-slot:heading>
                                {{ $compliance->document_type }}
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Document Status</x-slot:heading>
                                {{ $compliance->document_status }}
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Submission Date</x-slot:heading>
                                {{ $compliance->submission_date }}
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Updated Date</x-slot:heading>
                                {{ $compliance->approval_date ?? 'n/a' }}
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Remarks</x-slot:heading>
                                {{ $compliance->remarks ?? 'n/a'}}
                            </x-admin.card-table-info-tr>
                </x-admin.card-table-info>
                @endif
            </div>
            @endforeach

            <!-- Batch Action Modal -->
            <div class="modal fade" id="batchActionModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark-low text-white">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="batchActionModalLabel">Batch Action Confirmation</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p id="batchActionModalMessage"></p>
                            <div class="mb-3">
                                <label for="batchActionRemarks" class="form-label">
                                    <span id="remarksLabel">Remarks</span>
                                    <span id="remarksRequired" class="text-danger">*</span>
                                </label>
                                <textarea class="form-control" id="batchActionRemarks" rows="3"></textarea>
                                <div class="invalid-feedback">Please provide a rejection reason</div>
                            </div>
                        </div>
                        <div class="modal-footer border-0">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form id="batchActionForm" method="POST">
                                @csrf
                                @method('PATCH')
                                <input type="hidden" name="compliance_type" id="modalComplianceType">
                                <input type="hidden" name="submission_date" id="modalSubmissionDate">
                                <button type="submit" class="btn" id="modalActionButton">
                                    <span id="buttonText">Confirm</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                @if($complianceRecords->where('document_status', 'pending')->count() > 0)
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Batch Approval</h5>
                            <button type="button" class="btn btn-success"
                                    onclick="setupBatchActionModal('approve', '{{ $complianceType }}', '{{ $complianceRecords->first()->submission_date }}')">
                                <i class="bi bi-check-all"></i> Approve All ({{ $complianceRecords->where('document_status', 'pending')->count() }} pending)
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Rejection Button -->
                <div class="col-md-6">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h5 class="card-title">Batch Rejection</h5>
                            <button type="button" class="btn btn-danger"
                                    onclick="setupBatchActionModal('reject', '{{ $complianceType }}', '{{ $complianceRecords->first()->submission_date }}')">
                                <i class="bi bi-x-circle"></i> Reject All ({{ $complianceRecords->where('document_status', 'pending')->count() }} pending)
                            </button>
                        </div>
                    </div>
                </div>
                @endif
        </div>
    <x-client.success-popup/>
</x-admin.dashboard-layout>

<script>

function setupBatchActionModal(action, complianceType, submissionDate) {
    const modal = new bootstrap.Modal(document.getElementById('batchActionModal'));
    const form = document.getElementById('batchActionForm');
    const remarksField = document.getElementById('batchActionRemarks');
    
    // Clear previous values
    remarksField.value = '';
    remarksField.classList.remove('is-invalid');
    
    // Configure modal
    if (action === 'approve') {
        document.getElementById('batchActionModalMessage').textContent = 
            `Approve ALL ${complianceType} documents?`;
        document.getElementById('modalActionButton').className = 'btn btn-success';
        document.getElementById('modalActionButton').textContent = 'Confirm Approval';
        form.action = "{{ route('admin.compliance.approve-batch', ['client' => $client]) }}";
        remarksField.required = false;
    } else {
        document.getElementById('batchActionModalMessage').textContent = 
            `Reject ALL ${complianceType} documents?`;
        document.getElementById('modalActionButton').className = 'btn btn-danger';
        document.getElementById('modalActionButton').textContent = 'Confirm Rejection';
        form.action = "{{ route('admin.compliance.reject-batch', ['client' => $client]) }}";
        remarksField.required = true;
    }
    
    // Set hidden values
    document.getElementById('modalComplianceType').value = complianceType;
    document.getElementById('modalSubmissionDate').value = submissionDate;
    
    // Handle form submission
    form.onsubmit = function(e) {
        // Manually add remarks to form data
        const remarksInput = document.createElement('input');
        remarksInput.type = 'hidden';
        remarksInput.name = 'remarks';
        remarksInput.value = remarksField.value;
        form.appendChild(remarksInput);
        
        if (action === 'reject' && !remarksField.value.trim()) {
            e.preventDefault();
            remarksField.classList.add('is-invalid');
            return false;
        }
        return true;
    };
    
    modal.show();
}

        document.getElementById('riskAssessmentForm').addEventListener('submit', function(event) {
                event.preventDefault(); // Stop default form submission
            
                let button = document.getElementById("assessRiskButton");
                let spinner = document.getElementById("assessRiskSpinner");
                let buttonText = document.getElementById("assessRiskText");
            
                // Show loading state
                spinner.classList.remove("d-none");
                buttonText.textContent = "Assessing...";
                button.disabled = true;
            
                fetch("{{ route('api.risk_assessment.store', $client) }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({})
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('successMessage').innerText = data.message;
                        var successModal = new bootstrap.Modal(document.getElementById('successModal'));
                        successModal.show();
            
                        successModal._element.addEventListener('hidden.bs.modal', function () {
                            location.reload();
                        });
                    } else {
                        alert(`❌ Error: ${data.message}`);
                    }
                })
                .catch(error => console.error("Fetch error:", error))
                .finally(() => {
                    // Restore button state after response
                    spinner.classList.add("d-none");
                    buttonText.textContent = "Assess Risk";
                    button.disabled = false;
                });
            });   
</script>
