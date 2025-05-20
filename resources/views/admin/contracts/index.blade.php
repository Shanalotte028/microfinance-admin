<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('dashboard') }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Contracts List
    </x-slot:heading>
     <div class="mb-4">
        <div class="mt-4">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exportContractModal">
                Export Contract Records
            </button>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#contractReportModal">
                Generate Contracts Report
            </button>
        </div>
    </div>
        <div class="row">
            <x-admin.card-table-list>
                <x-slot:heading>Contracts List</x-slot:heading>
                    <x-slot:table_row>
                        <th>Contract ID</th>
                        <th>Party</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </x-slot:table_row>
                @foreach ($contracts as $contract)
                    <tr>
                        <td>{{ $contract->id }}</td>
                        @if(isset($contract->client))
                            <td>{{ $contract->client->first_name }} {{ $contract->client->last_name }} (Client)</td>
                        @elseif(isset($contract->user))
                            <td>{{ $contract->user->first_name }} {{ $contract->user->last_name }} (Employee)</td>
                        @elseif($contract->template->id === 3)
                            <td>{{$contract->vendor_name}}</td>
                        @else
                            <td>{{ $contract->government_agency ?? '-'}} </td>
                        @endif
                        <td>
                            @php
                                $status = $contract->status ?? '-';
                                $badgeClass = match($status) {
                                    'active' => 'bg-success',
                                    'terminated' => 'bg-danger',
                                    'expired' => 'bg-danger',
                                    'pending_signature' => 'bg-warning text-dark',
                                    'draft' => 'bg-secondary'
                                };
                            @endphp
                            <span class="badge {{ $badgeClass }}">
                                {{ ucfirst($status) }}
                            </span>
                        </td>
                        <td>
                            <a href="{{ route('admin.contracts.show', $contract) }}" class="btn btn-success">View</a>
                            {{-- @if($contract->status === 'draft')
                                <a href="{{ route('contracts.send', $contract->id) }}" class="btn btn-primary">Send for Signature</a>
                            @endif --}}
                        </td>
                    </tr>
                @endforeach
            </x-admin.card-table-list>
        </div>
        <div class="modal fade" id="exportContractModal" tabindex="-1" aria-labelledby="exportContractModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content bg-dark text-light">
                <div class="modal-header border-0">
                    <h5 class="modal-title" id="exportContractModalLabel">Export Contract Records</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('contract.export') }}" method="GET">
                        <div class="mb-3">
                            <label for="contract_export_type">Export Type:</label>
                            <select class="form-control" id="contract_export_type" name="export_type" required>
                                <option value="monthly">Monthly</option>
                                <option value="yearly">Yearly</option>
                            </select>
                        </div>

                        <!-- Month Picker (Shown for Monthly Export) -->
                        <div class="mb-3" id="contract_month_picker">
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

        <div class="modal fade" id="contractReportModal" tabindex="-1" aria-labelledby="contractReportModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content bg-dark text-light">
                    <div class="modal-header border-0">
                        <h5 class="modal-title" id="contractReportModalLabel">Generate Contract Report</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('contract.report') }}" method="GET">
                            <div class="mb-3">
                                <label for="report_type">Report Type:</label>
                                <select class="form-control" id="contract_report_type" name="report_type" required>
                                    <option value="monthly">Monthly</option>
                                    <option value="yearly">Yearly</option>
                                </select>
                            </div>

                            <!-- Month Picker (Hidden for Yearly Report) -->
                            <div class="mb-3" id="contract_month_picker">
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
    </div>
<x-client.success-popup></x-client.success-popup>
</x-admin.dashboard-layout>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contractReportType = document.getElementById('contract_report_type');
        const contractMonthPicker = document.getElementById('contract_month_picker');

        contractReportType.addEventListener('change', function () {
            contractMonthPicker.style.display = this.value === 'yearly' ? 'none' : 'block';
        });

        // Set initial visibility on page load
        contractMonthPicker.style.display = contractReportType.value === 'yearly' ? 'none' : 'block';
    });
</script>


<script>
    document.addEventListener('DOMContentLoaded', function () {
        const contractExportType = document.getElementById('contract_export_type');
        const contractMonthPicker = document.getElementById('contract_month_picker');

        contractExportType.addEventListener('change', function () {
            contractMonthPicker.style.display = this.value === 'yearly' ? 'none' : 'block';
        });

        // Set initial visibility
        contractMonthPicker.style.display = contractExportType.value === 'yearly' ? 'none' : 'block';
    });
</script>
