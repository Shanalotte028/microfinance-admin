<x-admin.dashboard-layout>
    <x-slot:heading>
        Compliance Records
    </x-slot:heading>
    <x-slot:heading_child>
        Compliance
    </x-slot:heading_child>
            <x-admin.table-data>
                <x-slot:heading>
                    Compliance
                </x-slot:heading>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client ID</th>
                        <th>Document Type</th>
                        <th>Document Status</th>
                        <th>Submission Date</th>
                        <th>Approval Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
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
                                <td>{{ $compliance->document_type }}</td>
                                <td>{{ $compliance->document_status }}</td>
                                <td>{{ $compliance->submission_date }}</td>
                                <td>{{ $compliance->approval_date ?? 'n/a'}}</td>
                                <td>
                                    <a href="{{ url('admin/clients/'.$compliance->client_id.'/compliance-records/'.$compliance->id) }}" class="btn btn-success">View</a> <!-- View button -->
                                </td>
                            </tr>
                    @endforeach
                </tbody>
            </x-admin.table-data>
</x-admin.dashboard-layout>