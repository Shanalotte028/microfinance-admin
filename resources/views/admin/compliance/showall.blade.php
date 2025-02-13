<x-admin.dashboard-layout>
    <x-slot:heading>
        Compliance Records
    </x-slot:heading>
    <x-slot:heading_child>
        Compliance
    </x-slot:heading_child>

    <div class="mb-4">
        <a href="{{ route('admin.compliances') }}" class="btn btn-secondary">All</a>
        <a href="{{ route('admin.compliances', ['status' => 'pending']) }}" class="btn btn-primary">Pending</a>
        <a href="{{ route('admin.compliances', ['status' => 'approved']) }}" class="btn btn-warning">Approved</a>
        <a href="{{ route('admin.compliances', ['status' => 'rejected']) }}" class="btn btn-success">Rejected</a>
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
                        <th>Approval Date</th>
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
                        <th>Approval Date</th>
                        <th>Action</th>
                    </tr>
                </tfoot>
                <tbody>                             
                    @foreach ($compliances as $compliance )
                            <tr>
                                <td>{{ $compliance->id }}</td>
                                <td>{{ $compliance->client_id }}</td>
                                <td>{{ optional($compliance->client)->email ?? 'n/a' }}</td>
                                <td>{{ $compliance->compliance_type }}</td>
                                <td>{{ $compliance->document_type }}</td>
                                <td>{{ $compliance->document_status }}</td>
                                <td>{{ $compliance->submission_date }}</td>
                                <td>{{ $compliance->approval_date ?? 'n/a'}}</td>
                                <td>
                                    <a href="{{ url('/clients/'.$compliance->client->id.'/compliance-records/'.$compliance->id) }}" class="btn btn-success">View</a> <!-- View button -->
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
</x-admin.dashboard-layout>