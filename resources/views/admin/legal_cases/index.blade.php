<x-admin.dashboard-layout>
    <x-slot:heading>
        Legal Cases
    </x-slot:heading>

            <!-- Filter Buttons -->
        <div class="mb-4">
            <a href="{{ route('admin.legal.index') }}" class="btn btn-secondary">All</a>
            <a href="{{ route('admin.legal.index', ['status' => 'open']) }}" class="btn btn-primary">Open</a>
            <a href="{{ route('admin.legal.index', ['status' => 'in_progress']) }}" class="btn btn-warning">In Progress</a>
            <a href="{{ route('admin.legal.index', ['status' => 'closed']) }}" class="btn btn-success">Closed</a>

            <div class="mt-4">
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportLegalCaseModal">
                    Export Legal Case Records
                </button>
                <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#legalCaseReportModal">
                    Generate Legal Case Report
                </button>
            </div>
        </div>

            <x-admin.table-data>
                <x-slot:heading>
                    Cases
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>Case Number</th>
                        <th>Title</th>
                        <th>Client</th>
                        <th>Assigned Lawyer</th>
                        <th>Status</th>
                        <th>Filing Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>                              
                    @foreach ($cases as $case)
                        <tr>
                            <td>{{ $case->case_number }}</td>
                            <td>{{ $case->title }}</td>
                            <td>{{ $case->client->first_name }} {{ $case->client->last_name }}</td>
                            <td>{{ $case->assignedLawyer->first_name }} {{ $case->assignedLawyer->last_name }}</td>
                            <td>
                                @php
                                    $status = $case->status ?? 'n/a';
                                    $badgeClass = match($status) {
                                        'open' => 'bg-success',
                                        'closed' => 'bg-danger',
                                        'in_progress' => 'bg-warning text-dark',
                                        default => 'bg-secondary'
                                    };
                                @endphp
                            
                                <span class="badge {{ $badgeClass }}">
                                    {{ ucfirst($status) }}
                                </span>
                            </td>
                            <td>{{ $case->filing_date }}</td>
                            <td>
                                <a href="{{ route('admin.legal.show', $case->id) }}" class="btn btn-success">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
            <x-client.success-popup/>
            
    <div class="modal fade" id="exportLegalCaseModal" tabindex="-1" aria-labelledby="exportLegalCaseModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="exportLegalCaseModalLabel">Export Lega Case Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('legal.export') }}" method="GET">
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
    <div class="modal fade" id="legalCaseReportModal" tabindex="-1" aria-labelledby="legalCaseReportModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="legalCaseReportModalLabel">Generate Legal Case Report</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('legal.report') }}" method="GET">
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