<x-admin.dashboard-layout>
    @include('components.admin.success-modal')
    <x-slot:back><a href="{{ route('admin.compliance.index', $client) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Compliance Record
    </x-slot:heading>
            <div class="row"> 
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
                        <x-slot:heading>ID</x-slot:heading>
                        {{ $fieldInvestigation->id }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Officer ID</x-slot:heading>
                        {{ $fieldInvestigation->officer_id ?? 'Unassigned' }}
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
                    <form action="{{ route('admin.compliance.approve', ['client' => $client->id, 'compliance' => $compliance->id]) }}" method="POST" onsubmit="return confirmApproval();">
                        @csrf
                        @method('PATCH')
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
                                <x-slot:heading>Approval Date</x-slot:heading>
                                {{ $compliance->approval_date ?? 'n/a' }}
                            </x-admin.card-table-info-tr>
                            <x-admin.card-table-info-tr>
                                <x-slot:heading>Remarks</x-slot:heading>
                                {{ $compliance->remarks ?? 'n/a'}}
                            </x-admin.card-table-info-tr>
                            @if ($compliance->document_status !=='approved' && $compliance->document_status !=='rejected')
                                <x-slot:button>
                                    <button class="btn btn-success" type="button" 
                                        data-bs-toggle="modal" 
                                        data-bs-target="#confirmModal"
                                        data-message="Are you sure you want to approve this compliance document?"
                                        data-form-action="{{ route('admin.compliance.approve', ['client' => $client->id, 'compliance' => $compliance->id]) }}">
                                        Approve
                                    </button>
                                </x-slot:button>
                            @endif
                    </form>
                    <x-slot:button2>
                        <form action="{{ route('admin.compliance.reject', ['client' => $client->id, 'compliance' => $compliance->id]) }}" method="POST" onsubmit="return confirmApproval();">
                            @csrf
                            @method('PATCH')
                            @if ($compliance->document_status !=='approved' && $compliance->document_status !=='rejected')
                                <button class="btn btn-danger mt-3" type="button" 
                                    data-bs-toggle="modal" 
                                    data-bs-target="#confirmModal"
                                    data-message="Are you sure you want to reject this compliance document?"
                                    data-form-action="{{ route('admin.compliance.reject', ['client' => $client->id, 'compliance' => $compliance->id]) }}">
                                    Reject
                                </button>
                            @endif
                        </form>
                    </x-slot:button2>
                </x-admin.card-table-info>
                @endif
            </div>
            @endforeach         
        </div>
    <x-client.success-popup/>
</x-admin.dashboard-layout>

<script>
       /*  document.addEventListener("DOMContentLoaded", function () {
            // Check if the document type is PDF
            @if($fileExtension === 'pdf')
                const url = '{{ Storage::url($compliance->document_path) }}';
                const pdfViewer = document.getElementById('pdf-viewer');
    
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
                });
            @endif
        }); */

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
