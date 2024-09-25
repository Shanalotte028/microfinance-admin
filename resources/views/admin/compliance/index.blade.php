<x-admin.dashboard-layout>
    <x-slot:heading>
        Compliance Records
    </x-slot:heading>
        <div class="row">
            <x-admin.card-table-list>
                <x-slot:heading>Compliance Record List</x-slot:heading>
                    <x-slot:table_row>
                            <th>Document Type</th>
                            <th>Document Status</th>
                            <th>Submission Date</th>
                            <th>Approval Date</th>
                            <th>Action</th>
                    </x-slot:table_row>
                    @foreach ($client->compliance_records as $compliance)
                                <tr>
                                    <td>{{ $compliance->document_type }}</td>
                                    <td>{{ $compliance->document_status }}</td>
                                    <td>{{ $compliance->submission_date }}</td>
                                    <td>{{ $compliance->approval_date ?? 'n/a' }}</td>
                                    <td>
                                        <a href="{{ url('admin/clients/'.$client->id.'/compliance-records/'.$compliance->id) }}" class="btn btn-success">View</a> <!-- View button -->
                                    </td>
                                </tr>
                            @endforeach
            </x-admin.card-table-list>
        </div>
</x-admin.dashboard-layout>