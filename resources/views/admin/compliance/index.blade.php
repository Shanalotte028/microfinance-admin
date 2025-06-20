<x-admin.dashboard-layout>
    <x-slot:back><a href="{{ route('admin.client.show', $client) }}" class="text-white"><i class="bi bi-arrow-left larger-icon"></i></a></x-slot:back>
    <x-slot:heading>
        Compliance Records
    </x-slot:heading>
        <div class="row">
            <x-admin.card-table-list>
                <x-slot:heading>Compliance Record List</x-slot:heading>
                    <x-slot:table_row>
                            <th>ID</th>
                            <th>Compliance Type</th>
                            <th>Document Type</th>
                            <th>Document Status</th>
                            <th>Submission Date</th>
                            <th>Updated Date</th>
                            <th>Action</th>
                    </x-slot:table_row>
                    @foreach ($client->compliance_records as $compliance)
                                <tr>
                                    <td>{{ $compliance->id ?? 'n/a'}}</td>
                                    <td>{{ $compliance->compliance_type }}</td>
                                    <td>{{ $compliance->document_type ?? 'n/a' }}</td>
                                    
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
                                    <td>{{ $compliance->submission_date ?? 'n/a'}}</td>
                                    <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                                    <td>
                                        <a href="{{ route('admin.compliance.show', ['client' => $client, 'complianceType'=> $compliance->compliance_type, 
                                        'submission_date'=> $compliance->submission_date] ) }}" class="btn btn-success">View</a> <!-- View button -->
                                    </td>
                                </tr>
                            @endforeach
            </x-admin.card-table-list>
        </div>
<x-client.success-popup></x-client.success-popup>
</x-admin.dashboard-layout>