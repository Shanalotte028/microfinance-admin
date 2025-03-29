<x-admin.dashboard-layout>
    <x-slot:heading>
        Pending Legal Cases
    </x-slot:heading>

    <x-admin.table-data>
        <x-slot:heading>
            Legal Cases Awaiting Approval
        </x-slot:heading>
        <thead>
            <tr>
                <th>Case Number</th>
                <th>Title</th>
                <th>Client</th>
                <th>Assigned Lawyer</th>
                <th>Description</th>
                <th>Filing Date</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>                              
            @foreach ($pendingLegalCases as $case)
                <tr>
                    <td>{{ $case->case_number }}</td>
                    <td>{{ $case->title }}</td>
                    <td>{{ $case->client->first_name }} {{ $case->client->last_name }}</td>
                    <td>{{ $case->assignedLawyer->first_name ?? 'Unassigned' }}</td>
                    <td>{{ Str::limit($case->description, 50) }}</td>
                    <td>{{ $case->filing_date }}</td>
                    <td>
                        <!-- Button to trigger modal -->
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#assignLawyerModal" 
                            onclick="setCaseId({{ $case->id }})">
                            Approve
                        </button>

                        <!-- Reject Form -->
                        <form action="{{ route('admin.reject.legal_cases', $case->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Reject</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </x-admin.table-data>

    <!-- Assign Lawyer Modal -->
    <div class="modal fade" id="assignLawyerModal" tabindex="-1" aria-labelledby="assignLawyerModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="assignLawyerModalLabel">Assign Lawyer</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form id="assignLawyerForm" method="POST" action="{{ route('admin.approve.legal_cases', ':id') }}">
                    @csrf
                    @method('POST')
                    <div class="modal-body">
                        <input type="hidden" name="case_id" id="caseId">
                        <div class="mb-3">
                            <label for="lawyer" class="form-label">Select Lawyer</label>
                            <select class="form-select" name="lawyer_id" required>
                                <option value="">-- Select Lawyer --</option>
                                @foreach ($lawyers as $lawyer)
                                    <option value="{{ $lawyer->id }}">{{ $lawyer->first_name }} {{ $lawyer->last_name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Assign & Approve</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <x-client.success-popup/>
</x-admin.dashboard-layout>

<script>
    function setCaseId(caseId) {
        document.getElementById("caseId").value = caseId;
        document.getElementById("assignLawyerForm").action = "{{ route('admin.approve.legal_cases', '') }}/" + caseId;
    }
</script>
