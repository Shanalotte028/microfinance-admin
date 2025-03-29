<x-admin.dashboard-layout>
    <x-slot name="heading">{{ $title }}</x-slot>

    <div class="card">
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Client</th>
                        <th>Compliance Type</th>
                        <th>Document Type</th>
                        <th>Status</th>
                        <th>Submission Date</th>
                        <th>Approval Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($records as $record)
                        <tr>
                            <td>{{ $record->id }}</td>
                            <td>{{ $record->client->name ?? 'N/A' }}</td>
                            <td>{{ $record->compliance_type }}</td>
                            <td>{{ $record->document_type }}</td>
                            <td>{{ ucfirst($record->document_status) }}</td>
                            <td>{{ $record->submission_date }}</td>
                            <td>{{ $record->approval_date ?? 'Pending' }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <a href="{{ route('admin.compliances') }}" class="btn btn-primary mt-3">Back</a>
        </div>
    </div>
</x-admin.dashboard-layout>
