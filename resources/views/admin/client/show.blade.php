<x-admin.dashboard-layout>
    @include('components.admin.success-modal')
    <x-slot:back><a href="{{ route('admin.client.index') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>User Overview</x-slot:heading>
    <x-slot:heading_child>{{ $client->first_name }} {{ $client->last_name }}</x-slot:heading_child>
        <div class="row">
            <!-- Left Column -->
            <div class="col-md-6">
                <x-admin.card-table-info> {{-- Client Info Card --}}
                    <x-slot:heading> {{ $client->email }} @can('clients.edit')<a class="btn btn-success d-none d-md-inline-block"  href="{{ route('admin.client.edit',['client' => $client->id]) }}">Edit Client</a>@endcan
                    </x-slot:heading>
                    <x-slot:heading_child>User ID: {{ $client->client_id }} @can('clients.edit')<a class="btn btn-success d-md-none" href="{{ route('admin.client.edit', ['client' => $client->id]) }}">Edit Client</a>@endcan</x-slot:heading_child>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Name</x-slot:heading>
                            {{ $client->first_name }} {{ $client->last_name ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Email</x-slot:heading>
                            {{ $client->email ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        {{-- <x-admin.card-table-info-tr>
                            <x-slot:heading>Blocked</x-slot:heading>
                            {{ $client->blocked ?? 'n/a'}}
                        </x-admin.card-table-info-tr> --}}
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
                        {{-- <x-admin.card-table-info-tr>
                            <x-slot:heading>Nationality</x-slot:heading>
                            {{ $client->nationality ?? 'n/a' }}
                        </x-admin.card-table-info-tr> --}}
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Marital Status</x-slot:heading>
                            {{ $client->marital_status ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Source of Income</x-slot:heading>
                            {{ $client->source_of_income ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        {{-- <x-admin.card-table-info-tr>
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
                        </x-admin.card-table-info-tr>  --}}
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Number Of Dependents</x-slot:heading>
                            {{ $client->number_of_dependents ?? 'n/a' }} {{ "(Child/Children)" }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Employment Status</x-slot:heading>
                            {{ $client->job_temporary ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Education Level</x-slot:heading>
                            {{ $client->education_level ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Ownership Status</x-slot:heading>
                            {{ $client->ownership_status ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Work Duration</x-slot:heading>
                            {{ $client->work_duration ?? 'n/a' }} {{ "Years" }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Job Tenure</x-slot:heading>
                            {{ $client->job_tenure ?? 'n/a' }} {{ "Years" }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Region</x-slot:heading>
                            {{ $client->address->region ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Province</x-slot:heading>
                            {{ $client->address->province ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>City</x-slot:heading>
                            {{ $client->address->city ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Barangay</x-slot:heading>
                            {{ $client->address->barangay ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Street</x-slot:heading>
                            {{ $client->address->permanent_street ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Postal Code</x-slot:heading>
                            {{ $client->address->postal_code ?? 'n/a'}}
                        </x-admin.card-table-info-tr>
                        <x-admin.card-table-info-tr>
                            <x-slot:heading>Created At</x-slot:heading>
                            {{ $client->created_at ?? 'n/a' }}
                        </x-admin.card-table-info-tr>
                </x-admin.card-table-info>        
                
                <!-- Compliance Records Card -->
                <x-admin.card-table-list>
                    <x-slot:heading>Compliance Record</x-slot:heading>
                    <x-slot:table_row>
                        <th class="col-3">Compliance Type</th>
                        <th class="col-3">Document Type</th>
                        <th class="col-3">Document Status</th>
                        <th class="col-3">Submission Date</th>
                        <th class="col-2">Approval Date </th>
                    </x-slot:table_row>
                    @foreach ($client->compliance_records->take(3) as $compliance)
                        <tr>
                            <td>{{ $compliance->compliance_type ?? 'n/a' }}</td>
                            <td>{{ $compliance->document_type ?? 'n/a' }}</td>
                            <td>{{ $compliance->document_status ?? 'n/a' }}</td>
                            <td>{{ $compliance->submission_date ?? 'n/a' }}</td>
                            <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                        </tr>
                    @endforeach
                    <x-slot:button><a href="{{ route('admin.compliance.index', $client) }}" class="btn btn-success">Show All</a></x-slot:button>
                </x-admin.card-table-list>
            </div>          
            <!-- Right Column -->
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
                {{-- Financial Card --}}
                <x-admin.card-table-info>
                    <x-slot:heading>Financial Details</x-slot:heading>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Total Amount Borrowed</x-slot:heading>
                        {{ $client->financial_details->total_loan_amount_borrowed ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    {{-- <x-admin.card-table-info-tr>
                        <x-slot:heading>Repayment Status</x-slot:heading>
                        {{ $client->financial_details->loan_repayment_status ?? 'n/a'  }}
                    </x-admin.card-table-info-tr> --}}
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Annual Income</x-slot:heading>
                        {{ $client->financial_details->annual_income ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Monthly Income</x-slot:heading>
                        {{ $client->financial_details->monthly_income ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Savings Account Balance</x-slot:heading>
                        {{ $client->financial_details->savings_account_balance ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Checking Account Balance</x-slot:heading>
                        {{ $client->financial_details->checking_account_balance ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Total Assets</x-slot:heading>
                        {{ $client->financial_details->total_assets ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Networth</x-slot:heading>
                        {{ $client->financial_details->networth ?? 'n/a' }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Credit Score</x-slot:heading>
                        {{ $client->financial_details->credit_score ?? 'n/a'  }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Late Payments</x-slot:heading>
                        {{ $client->financial_details->late_payments ?? 'n/a'  }}
                    </x-admin.card-table-info-tr>
                    <x-admin.card-table-info-tr>
                        <x-slot:heading>Loan Defaults</x-slot:heading>
                        {{ $client->financial_details->loan_defaults ?? 'n/a'  }}
                    </x-admin.card-table-info-tr>
                    <x-slot:button>
                        @if(isset($client->financial_details) && isset($client->financial_details->id))
                            <a href="{{ route('admin.financial.show', ['client'=>$client, 'financial' => $client->financial_details->id])}}" class="btn btn-success">Show Loans</a>
                        @endif
                    </x-slot:button>
                </x-admin.card-table-info>
            </div>
        </div>
        <x-client.success-popup/>

        <script>
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
            
</x-admin.dashboard-layout>