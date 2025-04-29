<x-admin.dashboard-layout>
    <x-slot:heading>
        Compliance Records
    </x-slot:heading>
    <x-slot:heading_child>
        Compliance
    </x-slot:heading_child>

    <div class="mb-4">
        <a href="{{ route('admin.compliances') }}" class="btn btn-secondary">All</a>
        <a href="{{ route('admin.compliances', ['status' => 'pending']) }}" class="btn btn-warning">Pending</a>
        <a href="{{ route('admin.compliances', ['status' => 'approved']) }}" class="btn btn-success">Approved</a>
        <a href="{{ route('admin.compliances', ['status' => 'rejected']) }}" class="btn btn-danger">Rejected</a>
        <div class="mt-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportComplianceModal">
                Export Compliance Records
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#complianceReportModal">
                Generate Compliance Report
            </button>
        </div>
    </div>
            <x-admin.table-data>
                <x-slot:heading>
                    Compliance
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>Compliance ID</th>
                        <th>Client ID</th>
                        <th>Client Email</th>
                        <th>Compliance Type</th>
                        <th>Document Type</th>
                        <th>Document Status</th>
                        <th>Submission Date</th>
                        <th>Updated Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>Compliance ID</th>
                        <th>Client ID</th>
                        <th>Client Email</th>
                        <th>Compliance Type</th>
                        <th>Document Type</th>
                        <th>Document Status</th>
                        <th>Submission Date</th>
                        <th>Updated Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>                             
                    @foreach ($clients as $client)
                        @foreach ($client->compliance_records as $compliance)
                            <tr>
                                <td>{{ $compliance->id }}</td>
                                <td>{{ $client->client_id }}</td> 
                                <td>{{ $client->email ?? 'n/a' }}</td>
                                <td>{{ $compliance->compliance_type }}</td>
                                <td>{{ $compliance->document_type }}</td>
                                <td>
                                    @php
                                        $status = $compliance->document_status ?? 'n/a';
                                        $badgeClass = match($status) {
                                            'approved' => 'bg-success',
                                            'rejected' => 'bg-danger',
                                            'pending' => 'bg-warning text-dark',
                                            default => 'bg-secondary'
                                        };
                                    @endphp
                                
                                    <span class="badge {{ $badgeClass }}">
                                        {{ ucfirst($status) }}
                                    </span>
                                </td>
                                <td>{{ $compliance->submission_date }}</td>
                                <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                                <td>
                                    <a href="{{ route('admin.compliance.show', ['client' => $client, 'complianceType' => $compliance->compliance_type,
                                    'submission_date'=> $compliance->submission_date]) }}" class="btn btn-success">
                                        View
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    @endforeach
                </tbody>
            </x-admin.table-data>

            <div class="modal fade" id="exportComplianceModal" tabindex="-1" aria-labelledby="exportComplianceModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content bg-dark text-light">
                        <div class="modal-header border-0">
                            <h5 class="modal-title" id="exportComplianceModalLabel">Export Compliance Records</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('compliance.export') }}" method="GET">
                                <div class="mb-3">
                                    <label for="export_type">Export Type:</label>
                                    <select class="form-control" id="export_type" name="export_type" required>
                                        <option value="monthly">Monthly</option>
                                        <option value="yearly">Yearly</option>
                                    </select>
                                </div>
            
                                <!-- Month Picker (Shown for Monthly Export) -->
                                <div class="mb-3" id="month_picker">
                                    <label for="month">Select Month:</label>
                                    <select class="form-control" name="month" id="month">
                                        @foreach(range(1, 12) as $m)
                                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                                {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <!-- Year Picker (Always Shown) -->
                                <div class="mb-3">
                                    <label for="year">Select Year:</label>
                                    <select class="form-control" name="year" id="year" required>
                                        @foreach(range(date('Y'), date('Y') - 5) as $y)
                                            <option value="{{ $y }}">{{ $y }}</option>
                                        @endforeach
                                    </select>
                                </div>
            
                                <button type="submit" class="btn btn-success">Download</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Modal -->
    <div class="modal fade" id="complianceReportModal" tabindex="-1" aria-labelledby="complianceReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="complianceReportModalLabel">Generate Compliance Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('compliance.report') }}" method="GET">
                        <div class="mb-3">
                            <label for="report_type">Report Type:</label>
                            <select class="form-control" id="report_type" name="report_type" required>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>

                        <!-- Month Picker (Hidden for Yearly Report) -->
                        <div class="mb-3" id="report_month_picker">
                            <label for="month">Select Month:</label>
                            <select class="form-control" name="month" id="month">
                                @foreach(range(1, 12) as $m)
                                    <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">
                                        {{ date('F', mktime(0, 0, 0, $m, 1)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Year Picker -->
                        <div class="mb-3">
                            <label for="year">Select Year:</label>
                            <select class="form-control" name="year" id="year" required>
                                @foreach(range(date('Y'), date('Y') - 5) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Generate Report</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin.dashboard-layout>

<!-- Script to Show/Hide Month Picker -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const exportType = document.getElementById('export_type');
        const monthPicker = document.getElementById('month_picker');
    
        exportType.addEventListener('change', function () {
            if (this.value === 'yearly') {
                monthPicker.style.display = 'none';
            } else {
                monthPicker.style.display = 'block';
            }
        });
    
        // Ensure the correct option is displayed when page loads
        if (exportType.value === 'yearly') {
            monthPicker.style.display = 'none';
        }
    });
</script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const reportType = document.getElementById('report_type');
        const monthPicker = document.getElementById('report_month_picker');

        reportType.addEventListener('change', function () {
            monthPicker.style.display = this.value === 'yearly' ? 'none' : 'block';
        });

        // Set initial visibility
        monthPicker.style.display = reportType.value === 'yearly' ? 'none' : 'block';
    });
</script>